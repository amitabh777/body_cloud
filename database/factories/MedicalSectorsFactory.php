<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use Modules\User\Entities\MedicalSector;

$factory->define(MedicalSector::class, function (Faker $faker) {
    $medicalSectors = ['Physicists','Blood & Organ Banks','Dentists','Healthcare Consultants',];
    return [
        'MedicalSectorName'=>$faker->unique()->randomElement($medicalSectors),
        'MedicalSectorDesc'=>''
    ];
});
