<?php 
namespace Modules\User\Repositories;

interface UserRepository{
    public function createWithRoles($data, $roleSlug);
    public function isAdmin($user);
    public function isSeller($user);
}