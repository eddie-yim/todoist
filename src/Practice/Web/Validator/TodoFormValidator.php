<?php
namespace Practice\Web\Validator;

use Practice\Web\Validator\Error\BindResult;

class TodoFormValidator implements Validator
{
    /**
     * @param $dto
     * @param BindResult $result
     */
    public static function validate($dto, BindResult $result)
    {
        if ($dto->getContent() == null) {
            $result->addError("content", "내용을 입력해주세요");
        }
    }
}
