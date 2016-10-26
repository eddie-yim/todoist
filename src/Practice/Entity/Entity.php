<?php

namespace Practice\Entity;

abstract class Entity
{
    /**
     * @return array
     */
    public function getObjectVars()
    {
        return get_object_vars($this);
    }
}