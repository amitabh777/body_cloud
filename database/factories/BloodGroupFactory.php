<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\User\Entities\BloodGroup;

$factory->define(BloodGroup::class, function (Faker $faker) {
    return [
        'BloodGroupName'=>$faker->randomElement(['A','O','B','A+','B+','ABO','AB']),
        'BloodGroupDesc'=>''
    ];
});
