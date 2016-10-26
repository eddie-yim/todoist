<?php
namespace Practice\Web\Converter;

use Practice\Entity\Enum\TodoStatus;
use Practice\Entity\Todo;
use Practice\Exception\InvalidSessionException;
use Silex\Application;

class TodoConverter implements Convertible
{
    /**
     * @param $entity
     * @param $dto
     * @return mixed
     */
    public static function from($entity, $dto)
    {
        $dto->setId($entity->getId());
        $dto->setContent(htmlspecialchars_decode($entity->getContent()));
        $dto->setStatus($entity->getStatus());
        return $dto;
    }

    /**
     * @param $dto
     * @param Application $app
     * @return null|Todo
     * @throws \Exception
     */
    public static function toEntity($dto, Application $app)
    {
        if ($app['session']->get('user') == null) {
            throw new InvalidSessionException();
        }

        $writer_id = $app['session']->get('user')->getId();
        $writer = $app['repository.user']->findOneById($writer_id);

        $todo = null;
        $id = $dto->getId();

        if ($id) {
            $todo = $app['repository.todo']->findOneById($id);

            if ($todo->getWriter()->getId() != $writer_id)
            {
                throw new \Exception('Cannot modify due to different user');
            }

            $todo->setContent($dto->getContent());
            $todo->setStatus($dto->getStatus());
            $todo->setLastModified(new \DateTime());
        } else {
            $todo = new Todo();
            $todo->setContent(htmlspecialchars($dto->getContent()));
            $todo->setStatus($dto->getStatus() ? $dto->getStatus() : TodoStatus::ACTIVE);
            $todo->setWriter($writer);
            $todo->setCreated(new \DateTime());
            $todo->setLastModified(new \DateTime());
        }

        return $todo;
    }
}