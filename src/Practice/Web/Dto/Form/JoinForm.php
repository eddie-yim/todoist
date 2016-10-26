<?php
namespace Practice\Web\Dto\Form;

use Symfony\Component\HttpFoundation\Request;

class JoinForm
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $repassword;

    /**
     * @param Request $request
     * @return JoinForm
     */
    public static function create(Request $request)
    {
        $form = new JoinForm();
        $form->email = $request->get('email');
        $form->name = $request->get('name');
        $form->password = $request->get('password');
        $form->repassword = $request->get('repassword');

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRepassword()
    {
        return $this->repassword;
    }
}
