<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

interface MethodInterface
{
    public function __construct(Api $apiService);
}