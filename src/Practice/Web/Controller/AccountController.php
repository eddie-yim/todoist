<?php
namespace Practice\Web\Controller;

use Practice\Entity\User;
use Practice\Exception\EmailDuplicationException;
use Practice\Service\UserService;
use Practice\Web\Converter\JoinConverter;
use Practice\Web\Converter\UserConverter;
use Practice\Web\Dto\Form\JoinForm;
use Practice\Web\Dto\Form\LoginForm;
use Practice\Web\Dto\UserDto;
use Practice\Web\Validator\Error\BindResult;
use Practice\Web\Validator\JoinFormValidator;
use Practice\Web\Validator\LoginFormValidator;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class AccountController implements ControllerProviderInterface
{
    /**
     * @var UserService
     */
    private $user_service;

    /**
     * AccountController constructor.
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
        $account_controller = $app['controllers_factory'];
        $account_controller->get('/login', [$this, 'loginForm']);
        $account_controller->post('/login', [$this, 'login']);
        $account_controller->get('/logout', [$this, 'logout']);
        $account_controller->get('/join', [$this, 'joinForm']);
        $account_controller->post('/join', [$this, 'join']);

        return $account_controller;
    }

    /**
     * @param Application $app
     * @param Request $req
     * @return mixed
     */
    public function loginForm(Application $app, Request $req)
    {
        $model_map = [];

        if ($req->get('errors')) {
            $model_map['errors'] = $req->get('errors');
            $model_map['data'] = $req->get('data');
        }

        return $app['twig']->render('account/login.twig', $model_map);
    }

    /**
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Application $app, Request $req)
    {
        $form = LoginForm::create($req);
        $result = new BindResult();
        LoginFormValidator::validate($form, $result);

        if ($result->hasErrors()) {
            $sub_req = Request::create('/account/login', 'GET', ['errors' => $result->getErrors(), 'data' => $form]);
            return $app->handle($sub_req, HttpKernelInterface::SUB_REQUEST, false);
        }

        $user = $this->user_service->findOneByEmail($form->getEmail());

        if ($user == null) {
            $result->addError("email", "해당 계정을 찾을 수 없습니다");
        } else if (!$user->passwordMatches($form->getPassword())) {
            $result->addError("password", "비밀번호가 일치하지 않습니다");
        } else if (!$user->passwordMatches($form->getPassword())) {
                $result->addError("password", "비밀번호가 일치하지 않습니다");
        }

        if ($result->hasErrors()) {
            $sub_req = Request::create('/account/login', 'GET', ['errors' => $result->getErrors(), 'data' => $form]);
            return $app->handle($sub_req, HttpKernelInterface::SUB_REQUEST, false);
        }

        $app['session']->set('user', UserConverter::from($user, new UserDto()));

        return $app->redirect('/');
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout(Application $app)
    {
        $app['session']->clear();

        return $app->redirect('/');
    }

    /**
     * @param Application $app
     * @param Request $req
     * @return mixed
     */
    public function joinForm(Application $app, Request $req)
    {
        $model_map = [];

        if ($req->get('errors')) {
            $model_map['errors'] = $req->get('errors');
            $model_map['data'] = $req->get('data');
        }

        return $app['twig']->render('account/join.twig', $model_map);
    }

    /**
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function join(Application $app, Request $req)
    {
        $form = JoinForm::create($req);
        $result = new BindResult();
        JoinFormValidator::validate($form, $result);

        if ($result->hasErrors()) {
            $sub_req = Request::create('/account/join', 'GET', ['errors' => $result->getErrors(), 'data' => $form]);
            return $app->handle($sub_req, HttpKernelInterface::SUB_REQUEST, false);
        }

        #save join form data as a new user
        $new_user = JoinConverter::toEntity($form, $app);

        try {
            $this->user_service->save($new_user);
        } catch (EmailDuplicationException $e) {
            $result->addError("email", "이미 가입되어 있는 이메일입니다");
            $sub_req = Request::create('/account/join', 'GET', ['errors' => $result->getErrors(), 'data' => $form]);
            return $app->handle($sub_req, HttpKernelInterface::SUB_REQUEST, false);
        }

        $app['session']->getFlashBag()->add('message', '가입이 완료되었습니다');

        return $app->redirect('/account/login', 301);
    }
}
