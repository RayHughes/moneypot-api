<?php

require '../vendor/autoload.php';

use MoneyPot\MoneyPot;

$appSecret = 'server-seed';
$authId = 0;

// Initialize MoneyPot
$moneyPot = new MoneyPot($appSecret);
$moneyPot->withAuthId($authId);

// Get auth info
$authInfoRes = $moneyPot->auth()->getInfo();

print_r($authInfoRes);
