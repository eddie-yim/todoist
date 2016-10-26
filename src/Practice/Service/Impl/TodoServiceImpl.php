<?php
namespace Practice\Service\Impl;

use Practice\Criteria\TodoCriteria;
use Practice\Entity\Todo;
use Practice\Repository\TodoRepository;
use Practice\Service\TodoService;

class TodoServiceImpl implements TodoService
{
    /**
     * @var TodoRepository
     */
    private $todo_repo;

    public function __construct(TodoRepository $todo_repo)
    {
        $this->todo_repo = $todo_repo;
    }

    public function findBy(TodoCriteria $criteria)
    {
        return $this->todo_repo->findBy($criteria);
    }

    public function findOneById($id)
    {
        return $this->todo_repo->findOneById($id);
    }

    public function save(Todo $todo): Todo
    {
        $this->todo_repo->save($todo);

        return $todo;
    }

    public function remove(Todo $todo)
    {
        $this->todo_repo->remove($todo);
    }
}

