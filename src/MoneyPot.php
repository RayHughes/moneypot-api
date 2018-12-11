<?php

namespace MoneyPot;

use MoneyPot\Methods\Auth;
use MoneyPot\Methods\Bets;
use MoneyPot\Methods\Buckets;
use MoneyPot\Methods\Pub;
use MoneyPot\Methods\Wallet;
use MoneyPot\Services\Api;

class MoneyPot
{
    /** @var Api $apiService */
    private $apiService;

    /**
     * @param string $appSecret
     * @param int $appId
     * @param int|null $authId
     */
    public function __construct(string $appSecret, int $appId, $authId = null)
    {
        $this->apiService = new Api($appSecret, $appId, $authId);
    }

    public function auth()
    {
        return new Auth($this->apiService);
    }

    public function bets()
    {
        return new Bets($this->apiService);
    }

    public function buckets()
    {
        return new Buckets($this->apiService);
    }

    public function pub()
    {
        return new Pub($this->apiService);
    }

    public function wallet()
    {
        return new Wallet($this->apiService);
    }
}