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
    
    public function StripePayment($prixTTC, $token) {

        try {
            \Stripe\Stripe::setApiKey("sk_test_NMS8iaVWh2STD5FqTP9PCeZz");


            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:

           return \Stripe\Charge::create([
                'amount' => $prixTTC,
                'currency' => 'eur',
                'description' => 'Paiement final',
                'source' => $token,
                'receipt_email' => 'djapanana@free.fr',
            ]);
        } catch (\Exception $e) {
            
            return false;
          
        }
    }
}
