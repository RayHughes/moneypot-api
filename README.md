# moneypot-api
[![Packagist](https://img.shields.io/packagist/v/rayhughes/moneypot-api.svg)](https://packagist.org/packages/rayhughes/moneypot-api)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg)](https://php.net/)
[![Licensed under the MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/RayHughes/moneypot-api/blob/master/LICENSE)

A PHP interface for interacting with the [MoneyPot API](https://portal.moneypot.com/docs/v2). 

## Prerequisites
Requires a valid [MoneyPot App](https://www.moneypot.com/apps/create) and credentials found in the 
[developer portal](https://portal.moneypot.com).

## Installation
```
composer require rayhughes/moneypot-api
```
## Usage

##### Initialize

```php
use MoneyPot\Moneypot;

$moneyPot = new MoneyPot($appSecret, $authId);
```

If you need to initialize the MoneyPot class globally or overwrite the auth id, you can do something like this:

```php
$moneyPot = new MoneyPot($appSecret);
$moneyPot->withAuthId($authId);
```

## Auth Methods;

```php
$auth = $moneyPot->auth();
```

##### Get Auth Info

```php
$authInfoRes = $auth->getInfo();
```

## Bet Methods

```php
$bets = $moneyPot->bets();
```

##### Get a New Bet Hash

```php
$betHashRes = $bets->getBetHash();
$betHash = $betHashRes['bet_hash'];
```

##### Check Bet Hash

```php
$isValid = $bets->checkBetHash($betHash);
```

##### Bet Simple Dice

```php
$betResult = $moneyPot->bets()
    ->withBetHash($betHash)
    ->withClientSeed($clientSeed)
    ->withCoin($coin)
    ->withWager($wager)
    ->withMaxSub($maxSub)
    ->betDiceSimple($condition, $target, $payout);
```

##### Bet 101 Dice

```php
$betResult = $moneyPot->bets()
    ->withBetHash($betHash)
    ->withClientSeed($clientSeed)
    ->withCoin($coin)
    ->withWager($wager)
    ->withMaxSub($maxSub)
    ->betDice101($condition, $target, $payout);
```

##### Bet Custom

```php
$payouts = [
    ['to' => 1000, 'from' => 0, 'value' => 2],
    ['to' => 2000, 'from' => 1001, 'value' => 2],
];

$betResult = $moneyPot->bets()
    ->withBetHash($betHash)
    ->withClientSeed($clientSeed)
    ->withCoin($coin)
    ->withWager($wager)
    ->withMaxSub($maxSub)
    ->betCustom($payouts);
```

## Bucket Methods
```php
$buckets = new $moneyPot->buckets();
```
##### Create Bucket

```php
$buckets->create($bucketName, $bucketType, $coin);
```

##### Destroy Bucket

```php
$buckets->destroy($bucketUuid);
```

##### Credit Bucket

```php
$buckets->credit($bucketUuid, $amount);
```

##### Debit Bucket

```php
$buckets->debit($bucketUuid, $amount);
```

##### List Buckets

```php
$buckets->getList();
```

##### Get Individual Bucket

```php
$buckets->getBucket($bucketUuid);
```

##### Get Bucket Transaction

```php
$buckets->getTransaction($bucketTxUuid);
```