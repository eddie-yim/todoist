<?php
namespace Practice\Criteria;

abstract class Criteria
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}