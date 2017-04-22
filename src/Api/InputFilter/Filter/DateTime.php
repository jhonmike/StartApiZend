<?php

namespace Api\InputFilter\Filter;

use Zend\Filter\AbstractFilter;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class DateTime extends AbstractFilter
{
    public function filter($value)
    {
        return new \DateTime($value);
    }
}
