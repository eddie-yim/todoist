<?php
namespace Practice\Web\Controller;

use Practice\Entity\Enum\TodoStatus;
use Practice\Service\UserService;
use Practice\Web\Converter\TodoConverter;
use Practice\Web\Dto\TodoDto;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class MainController implements ControllerProviderInterface
{
    /**
     * @var UserService
     */
    private $user_service;

    /**
     * MainController constructor.
     * @param UserService $user_service
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $main_controller = $app['controllers_factory'];
        $main_controller->get('/', [$this, 'index']);

        return $main_controller;
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index(Application $app)
    {
        $model_map = [];

        if ($app['session']->get('user') == null) {
            return $app->redirect('/account/login');
        }

        $writer_id = $app['session']->get('user')->getId();
        $writer = $this->user_service->findOneById($writer_id);
        $todos = $writer->getTodos();

        $todos_dto = [];

        $remains_count = 0;

        foreach ($todos as $todo) {
            $todo_dto = TodoConverter::from($todo, new TodoDto());
            array_push($todos_dto, $todo_dto);

            if (TodoStatus::ACTIVE === $todo->getStatus()) {
                $remains_count++;
            }
        }

        $model_map['todos'] = $todos_dto;
        $model_map['total_count'] = count($todos);
        $model_map['remains_count'] = $remains_count == 0 ? 'No items left' : $remains_count.' item'.($remains_count > 1 ? 's' : '').' left';

        return $app['twig']->render('index.twig', $model_map);
    }
}
