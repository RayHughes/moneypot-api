<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Auth extends AbstractMethod implements MethodInterface
{
    CONST INFO_ROUTE = 'auth';

    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }

    public function info()
    {
        return $this->apiService->sendPayload(self::INFO_ROUTE);
    }
}