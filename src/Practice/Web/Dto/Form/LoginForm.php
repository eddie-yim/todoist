<?php
namespace Practice\Web\Dto\Form;

use Symfony\Component\HttpFoundation\Request;

class LoginForm
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param Request $request
     * @return LoginForm
     */
    public static function create(Request $request)
    {
        $form = new LoginForm();
        $form->email = $request->get('email');
        $form->password = $request->get('password');

        return $form;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
