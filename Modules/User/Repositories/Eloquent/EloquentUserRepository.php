<?php

namespace Modules\User\Repositories\Eloquent;

use App\Helpers\CustomHelper;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Role;
use Modules\User\Entities\RolesUser;
use Modules\User\Entities\UserRole;
use Modules\User\Repositories\UserRepository;

class EloquentUserRepository implements UserRepository
{

    protected $model;
    function __construct(User $user)
    {
        $this->model = $user;
    }

    //Create user with roles
    public function createWithRoles($data, $roleSlug)
    {
        //Hash encrypt password
        $data['Password'] = Hash::make($data['Password']);
        $data['UniqueID'] = CustomHelper::getNewUniqueId();
        $user = null;
        DB::beginTransaction();
        try {
            $user = User::create($data);
            $role = Role::where('RoleSlug', $roleSlug)->first();
            $userRole = ['RoleID' => $role->RoleID, 'UserID' => $user->UserID];
            UserRole::create($userRole);
            Log::info('db trans executed: ');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Create user with role: ' . $e->getMessage());
            return false;
        }
        return $user;
    }

    //Update only user details
    public function updateUserDetails($data, $roleSlug)
    {
        //Hash encrypt password
        $data['Password'] = Hash::make($data['Password']);
        $data['UniqueID'] = CustomHelper::getNewUniqueId();
        $user = null;
        DB::beginTransaction();
        try {
            $user = User::create($data);
            $role = Role::where('RoleSlug', $roleSlug)->first();
            $userRole = ['RoleID' => $role->RoleID, 'UserID' => $user->UserID];
            UserRole::create($userRole);
            Log::info('db trans executed: ');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Create user with role: ' . $e->getMessage());
            return false;
        }
        return $user;
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
