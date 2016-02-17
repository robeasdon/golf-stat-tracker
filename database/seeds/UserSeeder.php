<?php

use App\Course;
use App\Round;
use App\Score;
use App\TeeSet;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create()->each(function ($user) {

            // store 10 rounds per user
            for ($i = 0; $i < 10; $i++) {

                // pick a random course to play on
                $course = Course::orderByRaw("RAND()")->first();

                // pick a random tee set on that course
                $teeSet = TeeSet::orderByRaw("RAND()")->where('course_id', $course->id)->first();

                $holes = $course->holes;

                $scores = [];

                // each round has 18 scores
                for ($j = 0; $j < 18; $j++) {
                    $scores[] = factory(Score::class)->make(['hole_id' => $holes[$j]->id]);
                }

                $round = factory(Round::class)->make(['tee_set_id' => $teeSet->id]);

                $round = $user->rounds()->save($round);
                $round->scores()->saveMany($scores);
            }

            $followed = [$user->id];

            // follow 10 random users
            for ($i = 0; $i < 10; $i++) {

                // pick a random user, that is not the current user and is not already followed
                $userToFollow = User::orderByRaw("RAND()")->whereNotIn('users.id', $followed)->first();

                $user->following()->attach($userToFollow);

                $followed[] = $userToFollow->id;

            }
        });
    }
}
