<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Pub extends AbstractMethod implements MethodInterface
{
    const APP_ROUTE = 'app/';

    const BANKROLL_ROUTE = 'bankroll/';

    const BET_LIST_ROUTE = 'list-bets/';

    const COIN_ROUTE = 'coin/';

    const TOKEN_ROUTE = 'token/';

    const USER_STATS = 'user-stats/';

    const GREATER_THAN = 'greater_than';

    const LESS_THAN = 'less_than';

    const ORDER_DESC = 'desc';

    const ORDER_ASC = 'asc';

    /** @var ?int $searchIndex */
    private $searchIndex;

    /** @var ?string $searchCondition */
    private $searchCondition;

    /** @var ?int $limit */
    private $limit;

    /** @var ?string $orderBy */
    private $orderBy;

    /** @var ?string $coin */
    private $coin;

    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppInfo(int $appId): array
    {
        $payload = ['app_id' => $appId];

        return $this->apiService->get(self::APP_ROUTE, $payload);
    }

    /**
     * @param string $accessToken
     * @return array
     */
    public function getAccessTokenInfo(string $accessToken): array
    {
        $payload = ['access_token' => $accessToken];

        return $this->apiService->get(self::TOKEN_ROUTE, $payload);
    }

    /**
     * @param string $confToken
     * @return array
     */
    public function getConfTokenInfo(string $confToken): array
    {
        $payload = ['confidential_token' => $confToken];

        return $this->apiService->get(self::TOKEN_ROUTE, $payload);
    }

    /**
     * @return array
     */
    public function getCoins(): array
    {
        return $this->apiService->get(self::COIN_ROUTE);
    }

    /**
     * @return array
     */
    public function getBankroll(): array
    {
        return $this->apiService->get(self::BANKROLL_ROUTE);
    }

    /**
     * @param string $userName
     * @return array
     */
    public function getUserStats(string $userName): array
    {
        $payload = ['uname' => $userName];

        return $this->apiService->get(self::USER_STATS, $payload);
    }

    /**
     * @param string $userName
     * @return array
     */
    public function getUserBets(string $userName): array {
        $payload = $this->generatePayload();

        $payload['uname'] = $userName;

        return $this->apiService->get(self::BET_LIST_ROUTE, $payload);
    }

    /**
     * @return array
     */
    public function getAllBets(): array {
        $payload = $this->generatePayload();

        return $this->apiService->get(self::BET_LIST_ROUTE, $payload);
    }

    /**
     * @param int $limit
     * @return Pub
     */
    public function withLimit(int $limit): Pub
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $coin
     * @return Pub
     */
    public function withCoin(string $coin): Pub
    {
        $this->coin = $coin;

        return $this;
    }

    /**
     * @param int $betId
     * @return Pub
     */
    public function withGreatThan(int $betId): Pub
    {
        $this->searchIndex = $betId;
        $this->searchCondition = self::GREATER_THAN;

        return $this;
    }

    /**
     * @param int $betId
     * @return Pub
     */
    public function withLessThan(int $betId): Pub
    {
        $this->searchIndex = $betId;
        $this->searchCondition = self::LESS_THAN;

        return $this;
    }

    /**
     * @return Pub
     */
    public function withOrderByDesc(): Pub
    {
        $this->orderBy = self::ORDER_DESC;

        return $this;
    }

    /**
     * @return Pub
     */
    public function withOrderByAsc(): Pub
    {
        $this->orderBy = self::ORDER_ASC;

        return $this;
    }

    /**
     * @return array
     */
    private function generatePayload(): array
    {
        $payload = [];

        if ($this->limit) {
            $payload['limit'] = $this->limit;
        }

        if ($this->searchCondition) {
            $payload[$this->searchCondition] = $this->searchIndex;
        }

        if ($this->orderBy) {
            $payload['order_by'] = $this->orderBy;
        }

        if ($this->coin) {
            $payload['coin'] = $this->coin;
        }

        return $payload;
    }
}
