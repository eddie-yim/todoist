<?php
namespace Practice\Repository\Impl;

use Doctrine\ORM\EntityManager;
use Practice\Criteria\TodoCriteria;
use Practice\Entity\Todo;
use Practice\Repository\TodoRepository;

class TodoRepositoryImpl extends AbstractRepository implements TodoRepository
{
    /**
     * TodoRepositoryImpl constructor.
     * @param EntityManager $entity_manager
     */
    public function __construct(EntityManager $entity_manager)
    {
        $this->em = $entity_manager;

        $this->repository = $this->em->getRepository('\Practice\Entity\Todo');
    }

    /**
     * @param TodoCriteria $criteria
     * @return array
     */
    public function findBy(TodoCriteria $criteria)
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
     * @param Todo $entity
     * @return Todo
     */
    public function save(Todo $entity): Todo
    {
        $this->em->persist($entity);

        $this->em->flush();

        return $entity;
    }

    /**
     * @param Todo $entity
     */
    public function remove(Todo $entity)
    {
        $this->em->remove($entity);

        $this->em->flush();
    }
}
