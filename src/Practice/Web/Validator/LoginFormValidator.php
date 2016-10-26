<?php
namespace Practice\Web\Validator;

use Practice\Web\Validator\Error\BindResult;

class LoginFormValidator implements Validator
{
    /**
     * @param $dto
     * @param BindResult $result
     */
    public static function validate($dto, BindResult $result)
    {
        if ($dto->getEmail() == null) {
            $result->addError("email", "이메일을 입력해주세요");
        } else if (!filter_var($dto->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $result->addError("email", "유효하지 않은 이메일입니다");
        }

        if ($dto->getPassword() == null) {
            $result->addError("password", "비밀번호를 입력해주세요");
        }
    }
}
