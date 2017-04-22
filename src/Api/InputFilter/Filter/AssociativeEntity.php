<?php

namespace Api\InputFilter\Filter;

use Zend\Filter\AbstractFilter;

class AssociativeEntity extends AbstractFilter
{
    protected $options = [
        'fields' => null,
    ];

    public function __construct($options = null)
    {
        if (is_array($options)) {
            $this->options = $options;
        }
    }

    public function filter($item)
    {
        $options = $this->getOptions();

        if (!is_array($item) || empty($item) || empty($options['fields'])) {
            return $item;
        }

        $result = [];
        foreach ($options['fields'] as $value) {
            if (array_key_exists($value, $item)) {
                $result[$value] = $item[$value];
            }
        }

        return $result;
    }
}
