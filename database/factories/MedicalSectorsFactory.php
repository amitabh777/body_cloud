<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use Modules\User\Entities\MedicalSector;

$factory->define(MedicalSector::class, function (Faker $faker) {
    return [
        'MedicalSectorName'=>$faker->name(),
        'MedicalSectorDesc'=>$faker->name()
    ];
});
