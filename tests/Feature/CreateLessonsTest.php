<?php

namespace Tests\Feature;

use Tests\TestCase;
use Bahdcasts\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLessonsTest extends TestCase
{
	use RefreshDatabase;

    public function test_a_user_can_create_lessons()
    {
    	// admin/3/lesson
    	$this->loginAdmin();
    	$this->withoutExceptionHandling();
    	$series = factory(Series::class)->create();
    	$lesson = [
    		"title" => 'new lesson',
    		'description' => 'new lesson description',
    		'episode_number' => 23,
    		'video_id' => 222222
    	];
    	$this->postJson("/admin/{$series->id}/lessons", $lesson)
    		->assertStatus(200)
    		->assertJson($lesson);

    	$this->assertDatabaseHas('lessons', [
    		'title' => $lesson['title']
    	]);
    }

    public function test_a_title_is_required_to_create_a_lesson()
    {
    	$this->loginAdmin();
    	$series = factory(Series::class)->create();
    	$lesson = [
    		'description' => 'new lesson description',
    		'episode_number' => 23,
    		'video_id' => 222222
    	];
    	$this->post("/admin/{$series->id}/lessons", $lesson)
    		->assertSessionHasErrors('title');
    }

    public function test_a_description_is_required_to_create_a_lesson()
    {
    	$this->loginAdmin();
    	$series = factory(Series::class)->create();
    	$lesson = [
    		"title" => 'new lesson',
    		'episode_number' => 23,
    		'video_id' => 222222
    	];
    	$this->post("/admin/{$series->id}/lessons", $lesson)
    		->assertSessionHasErrors('description');
    }

    public function test_an_episode_number_is_required_to_create_a_lesson()
    {
    	$this->loginAdmin();
    	$series = factory(Series::class)->create();
    	$lesson = [
    		"title" => 'new lesson',
    		'description' => 'description',
    		'video_id' => 222222
    	];
    	$this->post("/admin/{$series->id}/lessons", $lesson)
    		->assertSessionHasErrors('episode_number');
    }

    public function test_a_video_id_is_required_to_create_a_lesson()
    {
    	$this->loginAdmin();
    	$series = factory(Series::class)->create();
    	$lesson = [
    		"title" => 'new lesson',
    		'description' => 'description',
    		'episode_number' => 232
    	];
    	$this->post("/admin/{$series->id}/lessons", $lesson)
    		->assertSessionHasErrors('video_id');
    }
}
