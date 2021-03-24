<?php 
namespace Modules\User\Repositories;

interface UserRepository{
    public function createWithRoles($data, $roleSlug);
    public function updateUserWithoutProfile(array $data,int $UserID);

    public function addStaffUser($data,$roleSlug);

}