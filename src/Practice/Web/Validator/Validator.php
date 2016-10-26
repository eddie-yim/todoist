<?php
namespace Practice\Web\Validator;

use Practice\Web\Validator\Error\BindResult;

interface Validator
{
    /**
     * @param $dto
     * @param BindResult $result
     * @return mixed
     */
    public static function validate($dto, BindResult $result);
}