<?php

namespace Api\InputFilter\Validator;

use Zend\Validator\AbstractValidator;

class EntityRelation extends AbstractValidator
{
    public function isValid($value)
    {
        return isset($value['id']);
    }
}
