<?php

/*
 * BET FLOW
 * 1) Get bet_hash
 * 2) Render bet_hash to user and allow user to define bet properties and client seed
 * 3) Place bet
 */

require '../vendor/autoload.php';

use MoneyPot\MoneyPot;

$appSecret = 'app-secret'; //found in App Dev Portal
$authId = 0;

//initialize MoneyPot
$moneyPot = new MoneyPot($appSecret, $authId);

$bets = $moneyPot->bets();

//get a new bet hash
$betHashRes = $bets->getBetHash();
$betHash = $betHashRes['bet_hash'];

/*
 * Place custom bet.
 *
 * WARNING: THIS SHOULD BE DONE AFTER THE BET HASH HAS BEEN RENDERED TO THE END USER AND THEY HAD THE ABILITY TO DEFINE
 * THEIR CLIENT SEED AND BET DETAILS
 */
$payouts = [
    ['to' => 1000, 'from' => 0, 'value' => 2],
    ['to' => 2000, 'from' => 1001, 'value' => 2],
];

$betResult = $bets->withBetHash($betHash)
    ->withClientSeed('client-seed')
    ->withCoin('btc')
    ->withWager(1)
    ->betCustom($payouts);

print_r($betResult);

/*
 * Place simple dice bet.
 *
 * WARNING: THIS SHOULD BE DONE AFTER THE BET HASH HAS BEEN RENDERED TO THE END USER AND THEY HAD THE ABILITY TO DEFINE
 * THEIR CLIENT SEED AND BET DETAILS
 */
$betResult = $bets->withBetHash($betHash)
    ->withClientSeed('client-seed')
    ->withCoin('btc')
    ->withWager(1)
    ->betDiceSimple('<', 49.5, 2);

print_r($betResult);

/*
 * Place 101 dice bet.
 *
 * WARNING: THIS SHOULD BE DONE AFTER THE BET HASH HAS BEEN RENDERED TO THE END USER AND THEY HAD THE ABILITY TO DEFINE
 * THEIR CLIENT SEED AND BET DETAILS
 */
$betResult = $bets->withBetHash($betHash)
    ->withClientSeed('client-seed')
    ->withCoin('btc')
    ->withWager(1)
    ->betDice101('<', 49, 2);

print_r($betResult);
