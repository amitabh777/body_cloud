<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $roles = config('user.const.roles');
        Role::where('RoleSlug','!=','nothing')->delete(); //deleting old entries
        $roleData = array();
        foreach($roles as $slug=>$role){
            $roleData = array('RoleName'=>$role,'RoleSlug'=>$slug);
             Role::create($roleData);
        }     
    }
}
