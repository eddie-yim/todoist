<?php
namespace Practice\Web\Validator\Error;

abstract class Error
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return $this->errors != null && count($this->errors) > 0;
    }

    /**
     * @param $property
     * @param $message
     * @throws \Exception
     */
    public function addError($property, $message)
    {
        try {
            $this->errors[$property] = $message;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * clear errors array
     */
    public function clearErrors()
    {
        $this->errors = [];
    }
}