<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Generator as Faker;
use Modules\User\Entities\MedicalSector;


class MedicalSectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        MedicalSector::where('MedicalSectorName','!=','nothing')->delete(); // delete previous records
       factory(MedicalSector::class, 4)->create();

        // $this->call("OthersTableSeeder");
    }
}
