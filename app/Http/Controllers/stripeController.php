<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class stripeController extends Controller
{
    public function __constructor()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function  charge(Request $request)
    {

        try {
            // Use Stripe's library to make requests...

            $stripe = new \Stripe\StripeClient(
                'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
            );

            $token = $stripe->tokens->create([
                'card' => [
                    'name' => $request->card['cardName'],
                    'number' => $request->card['cardNumber'],
                    'exp_month' => $request->card['cardMonth'],
                    'exp_year' => $request->card['cardYear'],
                    'cvc' => $request->card['cardCvv'],
                ],
            ]);

            $stripe->charges->create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'source' => $token, //obtained with stripe js
                'description' => $request->description,
                'receipt_email' => $request->email
            ]);

            return response()->json([
                'success' => true
            ]);
        } catch (\Stripe\Exception\CardException $e) {


            // Since it's a decline, \Stripe\Exception\CardException will be caught
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly

            return response()->json($e->getJsonBody());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API

            return response()->json($e->getJsonBody());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)

            return response()->json($e->getJsonBody());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed

            return response()->json($e->getJsonBody());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return response()->json($e->getJsonBody());
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe

            return response()->json($e->getJsonBody());
        }
    }
}
