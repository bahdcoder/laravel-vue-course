<?php

namespace Bahdcasts\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function showSubscriptionForm() {
        return view('subscribe');
    }
    
    public function subscribe() {
        return auth()->user()
                ->newSubscription(
                    request('plan'), request('plan')
                )->create(
                    request('stripeToken')
                );
    }
}
