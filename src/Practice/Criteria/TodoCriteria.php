<?php
namespace Practice\Criteria;

use Practice\Entity\User;

class TodoCriteria extends Criteria
{
    /**
     * @var User
     */
    protected $writer;

    /**
     * @return User
     */
    public function getWriter(): User
    {
        return $this->writer;
    }

    /**
     * @param User $writer
     */
    public function setWriter(User $writer)
    {
        $this->writer = $writer;
    }
}