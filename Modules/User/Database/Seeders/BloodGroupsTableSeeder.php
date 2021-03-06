<?php

namespace Modules\User\Database\Seeders;

use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\BloodGroup;

class BloodGroupsTableSeeder extends Seeder
{
    protected $faker;
    public function __construct(Faker $faker)
    {   
        $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        factory(BloodGroup::class, 3)->create();
        // for($i=0;$i<3;$i++){
        //     $row = array('DocumentTypeName'=>$this->faker->randomLetter(),'DocumentTypeDesc'=>$this->faker->name);
        //     BloodGroup::create($row);
        // }
        // $this->call("OthersTableSeeder");
    }
}
