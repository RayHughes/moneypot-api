<?php

namespace MoneyPot\Methods;

use MoneyPot\Services\Api;

class Bets extends AbstractMethod implements MethodInterface
{
    /**
     * @param Api $apiService
     */
    public function __construct(Api $apiService)
    {
        parent::__construct($apiService);
    }

    /**
     * @param $target
     * @param $condition
     * @param $wager
     * @param $payout
     * @param $clientSeed
     */
    public function diceSimple($target, $condition, $wager, $payout, $clientSeed)
    {

    }

    public function dice101()
    {

    }

    public function custom()
    {

    }
}