<?php

namespace Tests\Feature;

use Bahdcasts\User;
use Tests\TestCase;
use Bahdcasts\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_without_a_plan_cannot_watch_premium_lessons() {
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create([  'premium' => 1 ]);
        $this->actingAs($user);
        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertRedirect('/subscribe');
    }

    public function fakeSubscribe($user) {
        // subscriptions 
        $user->subscriptions()->create([
            'name' => 'yearly', 
            'stripe_id' => 'FAKE_STRIPE_ID',
            'stripe_plan' => 'yearly',
            'quantity' => 1
        ]); 
    }
}
