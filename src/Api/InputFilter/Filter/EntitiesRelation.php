<?php

namespace Api\InputFilter\Filter;

use Zend\Filter\AbstractFilter;

class EntitiesRelation extends AbstractFilter
{
    public function filter($allArray)
    {
        if (!is_array($allArray)) {
            return $allArray;
        }
        $result = [];
        foreach ($allArray as $value) {
            $result[] = (is_array($value) && isset($value['id'])) ? ['id' => $value['id']] : $value ;
        }
        return $result;
    }
}
