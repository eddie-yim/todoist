<?php
namespace Practice\Web\Validator;

use Practice\Web\Validator\Error\BindResult;

class JoinFormValidator implements Validator
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

        if ($dto->getName() == null) {
            $result->addError("name", "이름을 입력해주세요");
        } else if (preg_match('/\s/', $dto->getName())) {
            $result->addError("name", "이름에 공백문자를 사용할 수 없습니다");
        } else if (strlen($dto->getName()) > 30) {
            $result->addError("name", "이름의 길이기 너무 깁니다");
        }

        if ($dto->getPassword() == null) {
           $result->addError("password", "비밀번호를 입력해주세요");
        }

        if ($dto->getRepassword() == null) {
            $result->addError("repassword", "비밀번호를 확인해주세요");
        }

        if ($dto->getPassword() != $dto->getRepassword()) {
            $result->addError("repassword", "비밀번호가 일치하지 않습니다");
        }
    }
}
