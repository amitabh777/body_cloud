<?php 
namespace Modules\User\Repositories;

interface UserRepository{
    public function createWithRoles($data, $roleSlug);
    public function updateUserWithoutProfile(array $data,int $UserID);

    public function isAdmin($user);
    public function isSeller($user);
}