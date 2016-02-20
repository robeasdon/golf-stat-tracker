<?php

use App\TeeType;
use Illuminate\Database\Seeder;

class TeeTypeSeeder extends Seeder
{
    public function run()
    {
        $teeTypes = array(
            array('name' => 'White', 'colour' => 'white'),
            array('name' => 'Yellow', 'colour' => 'yellow'),
            array('name' => 'Red', 'colour' => 'red')
        );

        foreach ($teeTypes as $teeType) {
            TeeType::create($teeType);
        }
    }
}
