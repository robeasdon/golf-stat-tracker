<?php

use App\Course;
use App\Hole;
use App\Tee;
use App\TeeSet;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        factory(Course::class, 50)->create()->each(function ($course) use ($faker) {

            // each course should have 3 tee sets, of types white, yellow and red
            $teeSets = [];

            $teeSets[] = $course->teeSets()->save(factory(TeeSet::class)->make(['tee_type_id' => 1]));
            $teeSets[] = $course->teeSets()->save(factory(TeeSet::class)->make(['tee_type_id' => 2]));
            $teeSets[] = $course->teeSets()->save(factory(TeeSet::class)->make(['tee_type_id' => 3]));

            // each course has 18 holes
            $holes = [];

            // todo: si should be odd on front and even on back, or vice versa

            $siValues = range(1, 18);
            shuffle($siValues);

            for ($i = 1; $i <= 18; $i++) {
                $si = $siValues[$i - 1];

                $holes[$i] = $course->holes()->save(factory(Hole::class)->make(['number' => $i, 'si_mens' => $si]));
            }

            // each hole has a tee for each tee set
            // we loop through from longest to shortest tee sets, so make sure each tee is shorter than the previous on each hole
            $previousYards = [];

            foreach ($teeSets as $teeSet) {
                for ($i = 1; $i <= 18; $i++) {
                    $hole = $holes[$i];

                    if ($hole->par === 3) {
                        $yards = $faker->numberBetween(100, isset($previousYards[$i]) ? $previousYards[$i] : 200);
                    } elseif ($hole->par === 4) {
                        $yards = $faker->numberBetween(300, isset($previousYards[$i]) ? $previousYards[$i] : 450);
                    } else {
                        $yards = $faker->numberBetween(450, isset($previousYards[$i]) ? $previousYards[$i] : 600);
                    }

                    $previousYards[$i] = $yards;

                    $tee = new Tee(['hole_id' => $holes[$i]->id, 'tee_set_id' => $teeSet->id, 'yards' => $yards]);

                    $teeSet->tees()->save($tee);
                }
            }

        });
    }
}
