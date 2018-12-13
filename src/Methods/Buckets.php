<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Buckets extends AbstractMethod implements MethodInterface
{
    const CREATE_ROUTE = 'buckets/create/';

    const DESTROY_ROUTE = 'buckets/destroy/';

    const CREDIT_ROUTE = 'buckets/credit/';

    const DEBIT_ROUTE = 'buckets/debit/';

    const LIST_ROUTE = 'buckets/';

    const SINGLE_ROUTE = 'buckets/single/';

    const TRANSACTION_ROUTE = 'buckets/transaction/';

    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }

    /**
     * @param string $bucketName
     * @param string $bucketType
     * @param string $coin
     * @return array
     */
    public function create(string $bucketName, string $bucketType, string $coin): array
    {
        $payload = [
            'bucket_name' => $bucketName,
            'bucket_type' => $bucketType,
            'coin' => $coin,
        ];

        return $this->apiService->post(self::CREATE_ROUTE, $payload);
    }

    /**
     * @param string $bucketUuid
     * @return array
     */
    public function destroy(string $bucketUuid): array
    {
        $payload = ['bucket_uuid' => $bucketUuid];

        return $this->apiService->post(self::DESTROY_ROUTE, $payload);
    }

    /**
     * @param string $bucketUuid
     * @param int $amount
     * @return array
     */
    public function credit(string $bucketUuid, int $amount): array
    {
        $payload = [
            'bucket_uuid' => $bucketUuid,
            'amount' => $amount,
        ];

        return $this->apiService->post(self::CREDIT_ROUTE, $payload);
    }

    /**
     * @param string $bucketUuid
     * @param int $amount
     * @return array
     */
    public function debit(string $bucketUuid, int $amount): array
    {
        $payload = [
            'bucket_uuid' => $bucketUuid,
            'amount' => $amount,
        ];

        return $this->apiService->post(self::DEBIT_ROUTE, $payload);
    }

    /**
     * @param string $bucketUuid
     * @return array
     */
    public function getBucket(string $bucketUuid): array
    {
        $payload = ['bucket_uuid' => $bucketUuid];

        return $this->apiService->get(self::SINGLE_ROUTE, $payload);
    }

    /**
     * @return array
     */
    public function getBuckets(): array
    {
        return $this->apiService->get(self::LIST_ROUTE);
    }

    /**
     * @param string $bucketTxUuId
     * @return array
     */
    public function getTransaction(string $bucketTxUuId): array
    {
        $payload = ['bucket_tx_uuid' => $bucketTxUuId];

        return $this->apiService->get(self::TRANSACTION_ROUTE, $payload);
    }
}
