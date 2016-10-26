<?php
namespace Practice\Web\Converter;


use Silex\Application;

interface Convertible
{
    /**
     * @param $entity
     * @param $dto
     * @return mixed
     */
    public static function from($entity, $dto);

    /**
     * @param $dto
     * @param Application $app
     * @return mixed
     */
    public static function toEntity($dto, Application $app);
}