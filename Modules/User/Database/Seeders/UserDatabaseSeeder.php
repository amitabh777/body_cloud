<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RoleTableSeeder::class);
        $this->call(DocumentTypesTableSeeder::class);
        $this->call(BloodGroupsTableSeeder::class);
        $this->call(MedicalSectorsTableSeeder::class);
    }
}
