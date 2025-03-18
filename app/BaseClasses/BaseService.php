<?php

namespace App\BaseClasses;

use Psr\Log\LoggerInterface;

class BaseService
{
    public function __construct(protected LoggerInterface $logger) {
        /**/
    }
}
