<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Pub extends AbstractMethod implements MethodInterface
{
    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }
}