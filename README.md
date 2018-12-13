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

##### Initialize
```php
use MoneyPot\Moneypot;

$moneyPot = new MoneyPot($appSecret, $authId);
```
An ```$authId``` is required on all API requests with the exclusion of those under the ```Pub()``` interface.

If you need to initialize the MoneyPot class globally or overwrite the ```$authId```, you can do something like this:

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
$bucket = $buckets->create($bucketName, $bucketType, $coin);
```

##### Destroy Bucket
```php
$isDestroyed = $buckets->destroy($bucketUuid);
```

##### Credit Bucket
```php
$bucketTransaction = $buckets->credit($bucketUuid, $amount);
```

##### Debit Bucket
```php
$bucketTransaction = $buckets->debit($bucketUuid, $amount);
```

##### Get All Buckets
```php
$allBuckets = $buckets->getBuckets();
```

##### Get Individual Bucket
```php
$bucket = $buckets->getBucket($bucketUuid);
```

##### Get Bucket Transaction
```php
$bucketTransactions = $buckets->getTransaction($bucketTxUuid);
```

## Public Methods
```php
$pub = $moneyPot->pub();
```
##### Get Confidential Token Info
```php
$confTokenInfo = $pub->getConfTokenInfo($confToken);
```

##### Get Access Token Info
```php
$accessTokenInfo = $pub->getAccessTokenInfo($accessToken);
```

##### Get Available Coins
```php
$coins = $pub->getCoins();
```

##### Get Bankroll Info
```php
$bankroll = $pub->getBankroll();
```

##### Get User Stats
```php
$userStats = $pub->getUserStats($userName);
```

##### Get All App Bets
```php
$allBets = $moneyPot->pub()
    ->withCoin($coin)
    ->withGreaterThan($betId)
    ->withLimit(100)
    ->withOrderByDesc()
    ->getAllBets();
```

##### Get User App Bets
```php
$userBets = $moneyPot->pub()
    ->withLessThan($betId)
    ->withOrderByAsc()
    ->getUserBets($userName);
```

## Wallet Methods
```php
$wallet = $moneyPot->wallet();
```

##### Send Tip
```php
$tip = $wallet->sendTip($toUserName, $coin, $amount);
```

##### Get New Wallet Address
```php
$newAddress = $wallet->getNewAddress($coin);
```

##### Get Wallet Transactions
```php
$walletTransactions = $wallet->getTransactions();
```

## Examples

##### [OAuth Flow (Process Login)](https://github.com/RayHughes/moneypot-api/blob/master/examples/oauthFlow.php)
##### [Bet Flow (Get Bet Hash and Bet)](https://github.com/RayHughes/moneypot-api/blob/master/examples/betFlow.php)
##### [CLI Bet Bot](https://github.com/RayHughes/moneypot-api/blob/master/examples/cliBetBot.php)
