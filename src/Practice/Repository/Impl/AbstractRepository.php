<?php
namespace Practice\Repository\Impl;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AbstractRepository
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;
}