<?php

namespace Api\InputFilter\Filter;

use Zend\Filter\AbstractFilter;

class EntityRelation extends AbstractFilter
{
    public function filter($value)
    {
        if (is_array($value) && isset($value['id'])) {
            return ['id' => $value['id']];
        }
        return $value;
    }
}
