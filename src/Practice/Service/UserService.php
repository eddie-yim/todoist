<?php
namespace Practice\Service;

use Practice\Entity\User;

interface UserService
{
    /**
     * @param $email
     * @return mixed
     */
    public function findOneByEmail($email);

    /**
     * @param $id
     * @return mixed
     */
    public function findOneById($id);

    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user);
}