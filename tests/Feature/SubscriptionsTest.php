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
        $lesson2 = factory(Lesson::class)->create([  'premium' => 0 ]);
        $this->actingAs($user);
        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertRedirect('/subscribe');
        $this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
            ->assertViewIs('watch');
    }

    public function test_a_user_on_any_plan_can_watch_all_lessons() {
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create([  'premium' => 1 ]);
        $lesson2 = factory(Lesson::class)->create([  'premium' => 0 ]);

        $this->actingAs($user);

        $this->fakeSubscribe($user);

        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
        ->assertViewIs('watch');
        $this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
        ->assertViewIs('watch');
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
