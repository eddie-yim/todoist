<?php
namespace Practice\Service;

use Practice\Criteria\TodoCriteria;
use Practice\Entity\Todo;

interface TodoService
{
    /**
     * @param TodoCriteria $criteria
     * @return mixed
     */
    public function findBy(TodoCriteria $criteria);

    /**
     * @param $id
     * @return mixed
     */
    public function findOneById($id);

    /**
     * @param Todo $todo
     * @return Todo
     */
    public function save(Todo $todo): Todo;

    /**
     * @param Todo $todo
     * @return mixed
     */
    public function remove(Todo $todo);
}