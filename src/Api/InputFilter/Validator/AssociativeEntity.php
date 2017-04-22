<?php

namespace Api\InputFilter\Validator;

use Zend\Validator\AbstractValidator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\InputFilter\Factory;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class AssociativeEntity extends AbstractValidator
{
    private $messages;
    private $options = [
        'validator' => null,
    ];

    public function isValid($item)
    {
        $isvalid = true;
        if (!is_array($item) || empty($item)) {
            return $isvalid;
        }

        $this->options = $this->getOptions();
        $filter = $this->getInputFilterInstance($this->options['inputfilter']);

        $this->messages = [];

        $filter->setData($item);
        $isvalid = $isvalid && $filter->isValid();
        foreach ($filter->getMessages() as $field => $errors) {
            foreach ($errors as $key => $string) {
                $this->messages[$field][$key] = $string;
            }
        }

        return $isvalid;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getInputFilterInstance($validatorConfig)
    {
        $factory = new Factory();
        $inputFilter = $this->inputFilter = $factory->createInputFilter($validatorConfig);

        return $inputFilter;
    }
}
