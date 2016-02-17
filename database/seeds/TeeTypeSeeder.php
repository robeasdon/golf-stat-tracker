<?php

use Illuminate\Database\Seeder;

class TeeTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('tee_types')->delete();

        $teeTypes = array(
            array('name' => 'White', 'colour' => 'white'),
            array('name' => 'Yellow', 'colour' => 'yellow'),
            array('name' => 'Red', 'colour' => 'red')
        );

        DB::table('tee_types')->insert($teeTypes);
    }
}
