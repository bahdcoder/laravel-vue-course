<?php

use Bahdcasts\User;
use Bahdcasts\Lesson;
use Bahdcasts\Series;
use Illuminate\Database\Seeder;

class BahdcastsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email' => 'kati@frantz.com',
        ]);

        factory(Series::class, 5)
                ->create()
                ->each(function($series) {
                    factory(Lesson::class, 10)->create([
                        'series_id' => $series->id
                    ]);
                });
    }
}
