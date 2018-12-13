<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Wallet extends AbstractMethod implements MethodInterface
{
    const TIP_ROUTE = 'wallet/tip/';

    const ADDRESS_ROUTE = 'wallet/new-address/';

    const TRANSACTION_ROUTE = 'wallet/transactions/auth';

    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }

    /**
     * @param string $toUserName
     * @param string $coin
     * @param int $amount
     * @return array
     */
    public function sendTip(string $toUserName, string $coin, int $amount): array
    {
        $payload = [
            'uname' => $toUserName,
            'coin' => $coin,
            'amount' => $amount,
        ];

        return $this->apiService->post(self::TIP_ROUTE, $payload);
    }

    /**
     * @param string $coin
     * @return array
     */
    public function getNewAddress(string $coin): array
    {
        $payload = ['coin' => $coin];

        return $this->apiService->get(self::ADDRESS_ROUTE, $payload);
    }

    /**
     * @return array
     */
    public function getTransactions(): array
    {
        return $this->apiService->get(self::ADDRESS_ROUTE);
    }
}
