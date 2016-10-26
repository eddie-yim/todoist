<?php
namespace Practice\Web\Converter;

use Practice\Entity\User;
use Practice\Web\Utils\Encryptions;
use Silex\Application;

class JoinConverter implements Convertible
{
    /**
     * @param $entity
     * @param $dto
     */
    public static function from($entity, $dto)
    {
    }

    /**
     * @param $dto
     * @param Application $app
     * @return User
     */
    public static function toEntity($dto, Application $app)
    {
        $user = new User();
        $user->setEmail($dto->getEmail());
        $user->setName($dto->getName());
        $encrypted_password = Encryptions::encrypt($dto->getPassword());
        $user->setEncryptedPassword($encrypted_password);
        $user->setCreated(new \DateTime());
        $user->setLastModified(new \DateTime());

        return $user;
    }
}
