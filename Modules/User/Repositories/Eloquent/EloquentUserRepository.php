<?php

namespace Modules\User\Repositories\Eloquent;

use App\Helpers\CustomHelper;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Role;
use Modules\User\Entities\Staff;
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
    /**
     * Update only user data without profile
     *
     * @param array $data [with exact db field columns]
     * @param integer $UserID
     * @return void
     */
    public function updateUserWithoutProfile(array $data, int $UserID)
    {
        //Hash encrypt password
        //$data['Password'] = Hash::make($data['Password']);
        DB::beginTransaction();
        try {
            $update = User::where('UserID',$UserID)->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update user without profile failed ' . $e->getMessage());
            return false;
        }
        return true;;
    }
    /**
     * create user(users table) with role
     * @param array $data
     * @param string $roleSlug [role slug]
     * @return mixed [false if error occur or user object if user created]
     */
    public function createUserWithRole($data,$roleSlug){
         //Hash encrypt password
         $data['Password'] = Hash::make($data['Password']);
         $data['UniqueID'] = CustomHelper::getNewUniqueId();
         $user = null;       
         try {
             $user = User::create($data);
             $role = Role::where('RoleSlug', $roleSlug)->first();
             $userRole = ['RoleID' => $role->RoleID, 'UserID' => $user->UserID];
             UserRole::create($userRole);
             Log::info('create user with role executed ');            
         } catch (Exception $e) {
             Log::error('Create user with role failed: ' . $e->getMessage());
             return false;
         }
         return $user;
    }

    /**
     * add staff user
     * @param array $data [user and staff profile data]
     * @param string $staffRole [role slug for staff]
     * @return boolean
     */
    public function addStaffUser($data,$staffRole){        
        $userData = $data['user'];
        $staffProfile = $data['profile'];
        $transStatus = false;
        $errorMsg = '';
        $user = [];
        DB::beginTransaction();
        try{
            $user = $this->createUserWithRole($userData,$staffRole);
            $staffProfile['UserID'] = $user->UserID;
            //add other data to staff profile
            Staff::create($staffProfile);
            //transaction finish now commit
            DB::commit();
            $transStatus = true;
        }catch(Exception $e){
            //something went wrong
            DB::rollBack();
            Log::error('Error add staff user : ' . $e->getMessage());     
            $errorMsg = $e->getMessage();    
        }
        if(!$transStatus){
            return $errorMsg;
        }
        return $user; //return user
    }

}
