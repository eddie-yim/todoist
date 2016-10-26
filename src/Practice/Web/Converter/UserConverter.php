<?php
namespace Practice\Web\Converter;

use Silex\Application;

class UserConverter implements Convertible
{
    /**
     * @param $entity
     * @param $dto
     * @return mixed
     */
    public static function from($entity, $dto)
    {
        $dto->setId($entity->getId());
        $dto->setEmail($entity->getEmail());
        $dto->setName($entity->getName());
        return $dto;
    }

    /**
     * @param $dto
     * @param Application $app
     */
    public static function toEntity($dto, Application $app)
    {
    }
}
