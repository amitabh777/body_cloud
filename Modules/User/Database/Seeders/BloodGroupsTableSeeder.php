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
        BloodGroup::truncate();//where('BloodGroupName', '!=', 'nothing')->delete();
        // factory(BloodGroup::class, 3)->create();

        $groups = ['A', 'O', 'B', 'A+', 'B+', 'ABO', 'AB'];      
        $rows = [];
        foreach ($groups as $group) {
            $rows[] = array('BloodGroupName' => $group, 'BloodGroupDesc' => '');
        }
        BloodGroup::insert($rows);
        // $this->call("OthersTableSeeder");
    }
}
