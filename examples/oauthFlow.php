<?php

/*
 * OAuth FLOW
 * 1) Get token
 * 2) Get token info
 * 3) Get auth info
 */

require '../vendor/autoload.php';

use MoneyPot\MoneyPot;

$appSecret = 'app-secret'; //found in App Dev Portal
$confToken = 'conf-token'; //$_GET['confidential_token'];

//initialize MoneyPot
$moneyPot = new MoneyPot($appSecret);

//get Confidential Token Info
$confTokenInfo = $moneyPot->pub()->getConfTokenInfo($confToken);

$authId = $confTokenInfo['auth_id'];

//set $authId
$moneyPot->withAuthId($authId);

//get auth info
$authInfo = $moneyPot->auth()->getInfo();

print_r($authInfo);