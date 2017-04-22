<?php

namespace Api\InputFilter\Validator;

use Zend\Validator\AbstractValidator;

class EntitiesRelation extends AbstractValidator
{
    public function isValid($allArray)
    {
        if (is_array($allArray)) {
            $valid = false;
            foreach ($allArray as $value) {
                $valid = isset($value['id']);
            }
            return $valid;
        }
        return isset($allArray['id']);
    }
}
