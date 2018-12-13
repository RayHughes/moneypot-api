<?php

require '../vendor/autoload.php';

use MoneyPot\MoneyPot;

$appSecret = 'app-secret';
$authId = 0;
$maxBets = 100;
$wager = 1;
$clientSeed = 'client-seed';
$coin = 'btc';
$target = 49.5;
$payout = $wager * 2;
$condition = '<';

$moneyPot = new MoneyPot($appSecret, $authId);
$bets = $moneyPot->bets();

$betHashRes = $bets->getBetHash();
$betHash = $betHashRes['bet_hash'];

for ($betIndex = 0; $betIndex < $maxBets; $betIndex++) {
    $betResult = $bets->withBetHash($betHash)
        ->withClientSeed($clientSeed)
        ->withCoin($coin)
        ->withWager($wager)
        ->betDiceSimple($condition, $target, $payout);

    print_r($betResult);

    if(isset($betResult['error'])) {
        break;
    }

    $betHash = $betResult['next_hash'];
}

