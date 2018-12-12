<?php

namespace MoneyPot\Methods;

use MoneyPot\Exceptions\BetsInvalidPayoutsException;
use MoneyPot\Exceptions\BetsInvalidPropertiesException;
use MoneyPot\Services\Api;

class Bets extends AbstractMethod implements MethodInterface
{
    const HASH_ROUTE = 'bets/hashes/';

    const CUSTOM_ROUTE = 'bets/custom/';

    const DICE_SIMPLE_ROUTE = 'bets/simple-dice/';

    const DICE_101_ROUTE = 'bets/101-dice/';

    /** @var ?string $betHash */
    private $betHash;

    /** @var ?string $clientSeed */
    private $clientSeed;

    /** @var ?int $wager */
    private $wager;

    /** @var ?float $maxSub */
    private $maxSub;

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
     * @param string $betHash
     * @return Bets $this
     */
    public function withBetHash(string $betHash): Bets
    {
        $this->betHash = $betHash;

        return $this;
    }

    /**
     * @param string $clientSeed
     * @return Bets $this
     */
    public function withClientSeed(string $clientSeed): Bets
    {
        $this->clientSeed = $clientSeed;

        return $this;
    }

    /**
     * @param int $wager
     * @return Bets $this
     */
    public function withWager(int $wager): Bets
    {
        $this->wager = $wager;

        return $this;
    }

    /**
     * @param float $maxSub
     * @return Bets $this
     */
    public function withMaxSub(float $maxSub): Bets
    {
        $this->maxSub = $maxSub;

        return $this;
    }

    /**
     * @param string $coin
     * @return Bets $this
     */
    public function withCoin(string $coin): Bets
    {
        $this->coin = $coin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBetHash()
    {
        return $this->apiService->post(self::HASH_ROUTE);
    }

    /**
     * @param string $betHash
     * @return mixed
     */
    public function checkBetHash(string $betHash)
    {
        $payload = ['bet_hash' => $betHash];

        return $this->apiService->get(self::HASH_ROUTE, $payload);
    }

    /**
     * @param string $condition
     * @param int $target
     * @param int $payout
     * @return mixed
     */
    public function betDiceSimple(string $condition, int $target, int $payout)
    {
        $payload = $this->generatePayload();

        $payload['target'] = $target;
        $payload['cond'] = $condition;
        $payload['payout'] = $payout;

        return $this->apiService->post(self::DICE_SIMPLE_ROUTE, $payload);
    }

    /**
     * @param string $condition
     * @param int $target
     * @param int $payout
     * @return mixed
     */
    public function betDice101(string $condition, int $target, int $payout)
    {
        $payload = $this->generatePayload();

        $payload['target'] = $target;
        $payload['cond'] = $condition;
        $payload['payout'] = $payout;

        return $this->apiService->post(self::DICE_101_ROUTE, $payload);
    }

    /**
     * @param array $payouts
     * @return mixed
     * @throws BetsInvalidPayoutsException
     */
    public function betCustom(array $payouts)
    {
        $payload = $this->generatePayload();

        foreach ($payouts as $payout) {
            if (!array_key_exists('to', $payout)
                || !array_key_exists('from', $payout)
                || !array_key_exists('value', $payout)
            ) {
                throw new BetsInvalidPayoutsException();
            }
        }

        $payload['payouts'] = $payouts;

        return $this->apiService->post(self::CUSTOM_ROUTE, $payload);
    }

    /**
     * @return array
     * @throws BetsInvalidPropertiesException
     */
    private function generatePayload()
    {
        if (!$this->betHash || !$this->clientSeed || !$this->wager) {
            throw new BetsInvalidPropertiesException();
        }

        $payload = [
            'bet_hash' => $this->betHash,
            'client_seed' => $this->clientSeed,
            'wager' => $this->wager,
        ];

        if ($this->coin) {
            $payload['coin'] = $this->coin;
        }

        if ($this->maxSub) {
            $payload['max_subsidy'] = $this->maxSub;
        }

        return $payload;
    }
}
