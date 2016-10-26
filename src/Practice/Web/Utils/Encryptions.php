<?php
namespace Practice\Web\Utils;

class Encryptions
{
    /**
     * @param string $password
     * @return bool|string
     */
    public static function encrypt(string $raw)
    {
        $options = ['cost' => 50];

        return password_hash($raw, PASSWORD_BCRYPT, $options);
    }

    /**
     * @param string $raw
     * @param string $encrypted
     * @return bool
     */
    public static function equals(string $raw, string $encrypted)
    {
        return password_verify($raw, $encrypted);
    }
}
