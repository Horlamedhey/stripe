<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey("sk_test_NWqA5pHdS6la3VIW2ESY48YY");
$token = $_POST['stripeToken'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$desc = $_POST['description'];
$charge = \Stripe\Charge::create([
  'amount' => $amount,
  'currency' => $currency,
  'description' => $desc,
  'source' => $token,
]);
echo($charge);