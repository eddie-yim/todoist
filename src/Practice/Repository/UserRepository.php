<?php
namespace Practice\Repository;

use Practice\Criteria\UserCriteria;
use Practice\Entity\User;

interface UserRepository
{
    /**
     * @param UserCriteria $criteria
     * @return mixed
     */
    public function findBy(UserCriteria $criteria);

    /**
     * @param $id
     * @return mixed
     */
    public function findOneById($id);

    /**
     * @param User $entity
     * @return User
     */
    public function save(User $entity): User;

    /**
     * @param User $entity
     * @return mixed
     */
    public function remove(User $entity);
}
