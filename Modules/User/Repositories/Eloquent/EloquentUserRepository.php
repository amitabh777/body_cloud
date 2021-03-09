<?php

namespace Modules\User\Repositories\Eloquent;

use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\RolesUser;
use Modules\User\Repositories\UserRepository;

class EloquentUserRepository implements UserRepository
{

    protected $model;
    function __construct(User $user)
    {
        $this->model = $user;
    }

    //Create user with roles
    public function createWithRoles($data, $role)
    {
        //Hash encrypt password
        $data['password'] = Hash::make($data['password']);
        $user = null;
        try {
            $user = DB::transaction(function () use ($data, $role, $user) {
                $user = User::create($data);
                $roleuser = array(
                    'role_id' => $role,
                    'user_id' => $user->id
                );
                RolesUser::create($roleuser);
                Log::info('db trans executed: ');
                return $user;
            });           
            return $user;
        } catch (Exception $e) {
            Log::error('Create user with role: ' . $e->getMessage());
            return false;
        }
    }

    public function isAdmin($user)
    {
        if (isset($user->roles)) {
            $role = $user->roles[0]->role;
            if ($role->slug == config('user.const.roles.admin')) {
                return true;
            }
        }
        return false;
    }

    public function isSeller($user)
    {
        if (isset($user->roles)) {
            $role = $user->roles[0]->role;
            if ($role->slug == config('user.const.roles.seller')) {
                return true;
            }
        }
        return false;
    }
}
