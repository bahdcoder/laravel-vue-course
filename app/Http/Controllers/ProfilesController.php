<?php

namespace Bahdcasts\Http\Controllers;

use Bahdcasts\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user) {
        return view('profile')
                ->withUser($user)
                ->withSeries($user->seriesBeingWatched());
    }

    public function updateCard() {
        $this->validate(request(), [
            'stripeToken' => 'required'
        ]);
        $token = request('stripeToken');
        $user = auth()->user();

        $user->updateCard($token);
        return response()->json('ok');
    }
}
