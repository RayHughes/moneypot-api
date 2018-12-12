<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Auth extends AbstractMethod implements MethodInterface
{
    CONST INFO_ROUTE = 'auth/';

    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        return $this->apiService->get(self::INFO_ROUTE);
    }
}
