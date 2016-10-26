<?php
namespace Practice\Repository\Impl;

use Doctrine\ORM\EntityManager;
use Practice\Criteria\UserCriteria;
use Practice\Entity\User;
use Practice\Repository\UserRepository;

class UserRepositoryImpl extends AbstractRepository implements UserRepository
{
    /**
     * UserRepositoryImpl constructor.
     * @param EntityManager $entity_manager
     */
    public function __construct(EntityManager $entity_manager)
    {
        $this->em = $entity_manager;

        $this->repository = $this->em->getRepository('\Practice\Entity\User');
    }

    /**
     * @param UserCriteria $criteria
     * @return array
     */
    public function findBy(UserCriteria $criteria)
    {
        return $this->repository->findBy($criteria->toArray());
    }

    /**
     * @param $id
     * @return null|object
     */
    public function findOneById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param User $entity
     * @return User
     */
    public function save(User $entity): User
    {
        $this->em->persist($entity);

        $this->em->flush();

        return $entity;
    }

    /**
     * @param User $entity
     */
    public function remove(User $entity)
    {
        $this->em->remove($entity);

        $this->em->flush();
    }
}
