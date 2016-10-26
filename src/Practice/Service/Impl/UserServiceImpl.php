<?php
namespace Practice\Service\Impl;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Practice\Criteria\UserCriteria;
use Practice\Entity\User;
use Practice\Exception\AmbiguousUserException;
use Practice\Exception\EmailDuplicationException;
use Practice\Repository\UserRepository;
use Practice\Service\UserService;

class UserServiceImpl implements UserService
{
    /**
     * @var UserRepository
     */
    private $user_repo;

    /**
     * UserServiceImpl constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    /**
     * @param $email
     * @return null|object
     * @throws AmbiguousUserException
     */
    public function findOneByEmail($email)
    {
        $criteria = new UserCriteria();

        $criteria->setEmail($email);

        $result = $this->user_repo->findBy($criteria);

        if ($result)
        {
            if (count($result) > 1)
            {
                throw new AmbiguousUserException();
            }

            return $result[0];
        }

        return null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOneById($id)
    {
        return $this->user_repo->findOneById($id);
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        try
        {
            return $this->user_repo->save($user);
        }
        catch (UniqueConstraintViolationException $e)
        {
            throw new EmailDuplicationException();
        }
    }
}
