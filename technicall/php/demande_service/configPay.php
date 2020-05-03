<?php
require_once "../../stripe-php-master/init.php";

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
$stripeDetails = array(
    "secretKey" => "sk_test_jYbgpW50Ig9Q0hhueiuS4Zz200Ol2tnGli",
    "publishableKey" => "pk_test_3XMiMgyrZP6sBjvfRwKENdpD004vJghqce"
);

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey($stripeDetails['secretKey']);
