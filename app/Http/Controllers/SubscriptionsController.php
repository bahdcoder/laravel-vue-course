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

    public function change() {
        $this->validate(request(), [
            'plan' => 'required'
        ]);
        $user = auth()->user();
        $userPlan = $user->subscriptions->first()->stripe_plan;

        if (request('plan') === $userPlan) {
            return redirect()->back();
        }

        $user->subscription($userPlan)->swap(request('plan'));

        return redirect()->back();
    }
}
