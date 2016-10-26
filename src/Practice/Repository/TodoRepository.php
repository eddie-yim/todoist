<?php
namespace Practice\Repository;

use Practice\Criteria\TodoCriteria;
use Practice\Entity\Todo;

interface TodoRepository
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
     * @param Todo $entity
     * @return Todo
     */
    public function save(Todo $entity): Todo;

    /**
     * @param Todo $entity
     * @return mixed
     */
    public function remove(Todo $entity);
}