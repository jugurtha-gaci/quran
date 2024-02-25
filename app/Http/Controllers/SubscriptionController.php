<?php

namespace App\Http\Controllers;

session_start();


use Exception;

use App\Models\User;

use App\Models\Group;

use App\Models\Setting;


use App\Models\Subscription;

use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Http\Controllers\PayPalClientController as PayPalClient;





class SubscriptionController extends Controller
{
  
    public function cardPayment(Request $request, $id) {
        $group_id = $id;
        if(count(User::where('group_id', $group_id)->get()) <= Group::find($group_id)->max_members) {

            $user = Auth::user();
            $amount = Setting::find(1)->subscription_price ? Setting::find(1)->subscription_price * 100 : env('SUBSCRIPTION_PRICE') * 100;
            $paymentMethod = $request->payment_method;

            if(!empty($paymentMethod)) {

                try {
                    $user->charge($amount, $request->payment_method);

                    $subscriptionStart = \Helper::nextGroupSession($group_id);
                    $subscriptionEnd = $subscriptionStart->copy()->addMonth();
            
                    Subscription::create([
                        "user_id" => $user->id,
                        "start_day" => $subscriptionStart,
                        "end_day" => $subscriptionEnd,
                        "expired" => 0,
                        'payment_method' => "card",
                        "amount" => $amount/100,
                        "payed_at" => now()
                    ]);
                    

                    User::find($user->id)->update([
                        "group_id" => $group_id
                    ]);

    
                    return redirect(route("dashboard"));

                } catch(CardException $e) {

                    return Redirect::back()->withErrors(['msg' => $e->getError()->message]);
                }
                
            } else {

                return Redirect::back()->withErrors(['msg' => 'Payment method is Invalid']);
            }
            

        }
        

    }



    public function paypalPayment($id) {
        $group_id = $id;
        if(count(User::where('group_id', $group_id)->get()) <= Group::find($group_id)->max_members) {

            $amount = Setting::find(1)->subscription_price ? Setting::find(1)->subscription_price : env('SUBSCRIPTION_PRICE');

            $client = PayPalClient::client();

            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');


            $request->body = array(
                'intent' => 'CAPTURE',
                "reference_id"  =>  "join_group",
                'application_context' =>
                    array(
                        'return_url' => route('checkout.paypal.execute', ['id' => $group_id]),
                        'cancel_url' => route('index-page')
                    ),
                'purchase_units' =>
                    array(
                        0 =>
                            array(
                                'amount' =>
                                    array(
                                        'currency_code' => 'USD',
                                        'value' => $amount
                                    )
                            )
                    )
            );

            try {
                $response = $client->execute($request);

                $_SESSION['paypal_order_id'] = strval($response->result->id);
                
                foreach($response->result->links as $link) {
                    if($link->rel == "approve") {
                        return redirect($link->href);
                    }
                }
            } catch (Exception $ex) {
                echo $ex->statusCode;
                print_r($ex->getMessage());
            }
            
        }
        
        
        
    }


    public function paypalExecute($id)
    {
        $user_id = auth()->user()->id;
        $group_id = $id;


        if(count(User::where('group_id', $group_id)->get()) <= Group::find($group_id)->max_members) {

            $subscriptionStart = \Helper::nextGroupSession($group_id);
            $subscriptionEnd = $subscriptionStart->copy()->addMonth();
            $amount = Setting::find(1)->subscription_price ? Setting::find(1)->subscription_price : env('SUBSCRIPTION_PRICE');
    
            $request = new OrdersCaptureRequest($_SESSION['paypal_order_id']);
    
            $client = PayPalClient::client();
    
            $request->prefer('return=representation');
    
    
            try {
            
                $response = $client->execute($request);
    
                if($response->result->status == "COMPLETED") {
    
                    Subscription::create([
                        "user_id" => $user_id,
                        "start_day" => $subscriptionStart,
                        "end_day" => $subscriptionEnd,
                        "expired" => 0,
                        'payment_method' => "paypal",
                        "amount" => $amount,
                        "payed_at" => now()
                    ]);
    
                    User::find($user_id)->update([
                        "group_id" => $group_id
                    ]);

                    session_unset();
                    session_destroy();

                    return redirect(route("dashboard"));
    
                }
    
                
            } catch (Exception $ex) {
                echo $ex->statusCode;
                print_r($ex->getMessage());
                print_r($_SESSION);
    
            }

        }

        
    }
   

}
