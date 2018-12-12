<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

abstract class AbstractMethod
{
    /** @var Api $apiService */
    protected $apiService;

    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        $this->apiService = $apiService;
    }
}
