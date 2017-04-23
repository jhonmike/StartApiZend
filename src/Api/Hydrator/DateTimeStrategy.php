<?php

namespace Api\Hydrator;

use Zend\Hydrator\Strategy\DefaultStrategy;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class DateTimeStrategy extends DefaultStrategy
{
    public function extract($value) : string
    {
        return $value->format('Y-m-d\TH:i:sP');
    }
}
