<?php
namespace Practice\Web\Controller;

use Practice\Entity\Enum\TodoStatus;
use Practice\Exception\InvalidSessionException;
use Practice\Service\TodoService;
use Practice\Service\UserService;
use Practice\Web\Converter\TodoConverter;
use Practice\Web\Dto\Form\TodoForm;
use Practice\Web\Dto\TodoDto;
use Practice\Web\Validator\Error\BindResult;
use Practice\Web\Validator\TodoFormValidator;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class TodoController implements ControllerProviderInterface
{
    /**
     * @var TodoService
     */
    private $todo_service;

    /**
     * @var UserService
     */
    private $user_service;

    /**
     * TodoController constructor.
     * @param TodoService $todo_service
     * @param UserService $user_service
     */
    public function __construct(TodoService $todo_service, UserService $user_service)
    {
        $this->todo_service = $todo_service;

        $this->user_service = $user_service;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $todo_controller = $app['controllers_factory'];
        $todo_controller->get('/', [$this, 'getTodos']);
        $todo_controller->post('/', [$this, 'saveTodo']);
        $todo_controller->put('/{id}', [$this, 'saveTodo']);
        $todo_controller->delete('/{id}', [$this, 'deleteTodo']);
        $todo_controller->delete('/', [$this, 'deleteTodos']);

        return $todo_controller;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function getTodos(Application $app)
    {
        if ($app['session']->get('user') == null) {
            $app->redirect('/account/login/form');
        }

        $todo_dtos = [];

        $writer_id = $app['session']->get('user')->getId();
        $writer = $this->user_service->findOneById($writer_id);
        $todos = $writer->getTodos();

        foreach ($todos as $todo) {
            $todo_dto = TodoConverter::from($todo, new TodoDto());
            array_push($todo_dtos, $todo_dto);
        }

        $model_map['todos'] = $todo_dtos;

        return $app['twig']->render('todo/list.twig', $model_map);
    }

    /**
     * @param Application $app
     * @param null $id
     * @param Request $req
     * @return mixed
     */
    public function saveTodo(Application $app, $id = null, Request $req)
    {
        $req->attributes->set('id', $id);
        $form = TodoForm::create($req);
        $result = new BindResult();
        TodoFormValidator::validate($form, $result);

        if ($result->hasErrors()) {
            throw new \RuntimeException();
        }

        $todo = TodoConverter::toEntity($form, $app);

        if ($form->getId() != null && !$todo->isOwnedBy($app['session']->get('user')->getId())) {
            throw new InvalidSessionException();
        }

        $this->todo_service->save($todo);

        $model_map = [];
        $model_map['todos'] = [TodoConverter::from($todo, new TodoDto())];

        return $app['twig']->render('todo/list.twig', $model_map);
    }

    /**
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteTodo(Application $app, $id)
    {
        $todo = $this->todo_service->findOneById($id);

        $this->todo_service->remove($todo);

        return $app->json(['result' => 'ok']);
    }

    /**
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteTodos(Application $app, Request $req)
    {
        if ($app['session']->get('user') == null) {
            throw new InvalidSessionException();
        }

        $writer_id = $app['session']->get('user')->getId();
        $writer = $this->user_service->findOneById($writer_id);
        $todos = $writer->getTodos();

        foreach($todos as $key => $todo) {
            if (TodoStatus::COMPLETED === $todo->getStatus()) {
                unset($todos[$key]);
            }
        }

        $this->user_service->save($writer);

        return $app->json(['result' => 'ok']);
    }
}