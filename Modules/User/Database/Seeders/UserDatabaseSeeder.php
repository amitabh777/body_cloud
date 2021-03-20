<?php

namespace Modules\User\Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\Role;
use Modules\User\Entities\UserRole;
use Modules\User\Repositories\UserRepository;

class UserDatabaseSeeder extends Seeder
{
    protected $userRepository;
    public function __construct(UserRepository $userrepo){
$this->userRepository =$userrepo;
    }
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

        User::where('Email','admin@test.com')->delete();
        //create dummy super admin
        $superAdmin = [
            'Email'=>'admin@test.com',
            'Phone'=>'77799977710',
            'Password'=>'12345678'
        ];
        $this->userRepository->createWithRoles($superAdmin,config('user.const.role_slugs.super_admin'));
    
    }
}
