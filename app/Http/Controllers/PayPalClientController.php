<?php

namespace App\Http\Controllers;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;




class PayPalClientController extends Controller
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }
    
   
    public static function environment()
    {
        $clientId = config('paypal.client_id');;
        $clientSecret = config('paypal.secret');;
        return new ProductionEnvironment($clientId, $clientSecret);
    }

}
