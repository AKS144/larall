<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('checkout');
    }

    public function stripe()
    {
        return view('stripe');
    }

    public function stripePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        Charge::create([
            'amount' => $request->get('total'),
            'currency' => 'inr',
            'description' => 'Your product info',
            'source' => $request->get('stripeToken'),
          //  'receipt_email' => $request->get('email'),
            'metadata' => [
                'order_id' => 2456,
            ]
        ]);
        // save your customer order to database here
        return back()->with('success_message', 'Thank you! your payment has been accepted');
    }
}
