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
     * @param int|null $authId
     */
    public function __construct(string $appSecret, ?int $authId = null)
    {
        $this->apiService = new Api($appSecret, $authId);
    }

    /**
     * @param int $authId
     * @return void
     */
    public function withAuthId(int $authId): void
    {
        $this->apiService->setAuthId($authId);
    }

    /**
     * @return Auth
     */
    public function auth(): Auth
    {
        return new Auth($this->apiService);
    }

    /**
     * @return Bets
     */
    public function bets(): Bets
    {
        return new Bets($this->apiService);
    }

    /**
     * @return Buckets
     */
    public function buckets(): Buckets
    {
        return new Buckets($this->apiService);
    }

    /**
     * @return Pub
     */
    public function pub(): Pub
    {
        return new Pub($this->apiService);
    }

    /**
     * @return Wallet
     */
    public function wallet(): Wallet
    {
        return new Wallet($this->apiService);
    }
}
