<?php

namespace Tests\Feature;

use Bahdcasts\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmEmailTest extends TestCase
{
	use RefreshDatabase;

    public function test_a_user_can_confirm_email()
    {
    	$this->withoutExceptionHandling();
    	
    	$user = factory(User::class)->create();	
    	$this->get("/register/confirm/?token={$user->confirm_token}")
    		->assertRedirect('/')
    		->assertSessionHas('success', 'Your email has been confirmed.'); 
    	$this->assertTrue($user->fresh()->isConfirmed());
    }

    public function test_a_user_is_redirected_if_token_is_wrong()
    {
    	$user = factory(User::class)->create();	
    	$this->get("/register/confirm/?token=WRONG_TOKEN")
    		->assertRedirect('/')
    		->assertSessionHas('error', 'Confirmation token not recognised.');
    }
}
