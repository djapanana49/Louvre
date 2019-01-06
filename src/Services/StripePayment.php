<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Services;

/**
 * Description of Stripe
 *
 * @author djapa
 */
class StripePayment {
    
    public function StripePayment($prixTTC,$token){
        
        try {
   \Stripe\Stripe::setApiKey("sk_test_NMS8iaVWh2STD5FqTP9PCeZz");


        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:

        \Stripe\Charge::create([
            'amount' => $prixTTC,
            'currency' => 'eur',
            'description' => 'Paiement final',
            'source' => $token,
            'receipt_email' => 'djapanana@free.fr',
        ]);
} catch(\Stripe\Error\Card $e) {
  // Since it's a decline, \Stripe\Error\Card will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];

  print('Status is:' . $e->getHttpStatus() . "\n");
  print('Type is:' . $err['type'] . "\n");
  print('Code is:' . $err['code'] . "\n");
  // param is '' in this case
  print('Param is:' . $err['param'] . "\n");
  print('Message is:' . $err['message'] . "\n");
} catch (\Stripe\Error\RateLimit $e) {
  // Too many requests made to the API too quickly
} catch (\Stripe\Error\InvalidRequest $e) {
  // Invalid parameters were supplied to Stripe's API
} catch (\Stripe\Error\Authentication $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
} catch (\Stripe\Error\ApiConnection $e) {
  // Network communication with Stripe failed
} catch (\Stripe\Error\Base $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
}
        
    }
     

}
