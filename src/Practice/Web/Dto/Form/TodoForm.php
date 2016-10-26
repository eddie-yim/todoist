<?php
namespace Practice\Web\Dto\Form;

use Practice\Entity\Enum\TodoStatus;
use Symfony\Component\HttpFoundation\Request;

class TodoForm
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $status = TodoStatus::ACTIVE;

    /**
     * @param Request $request
     * @return TodoForm
     */
    public static function create(Request $request)
    {
        $form = new TodoForm();
        $form->id = $request->get('id');
        $form->content = $request->get('content');
        $form->status = $request->get('status');

        return $form;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
