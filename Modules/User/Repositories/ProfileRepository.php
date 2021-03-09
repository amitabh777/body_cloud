<?php

namespace Modules\User\Repositories;

interface ProfileRepository
{
    // public function createWithRoles($data,$role);
    // public function isAdmin($user);
    public function patientProfileUpdate($data, $userid);
    public function doctorProfileUpdate($data, $userid);
    public function hospitalProfileUpdate($data, $userid);
    public function ambulanceProfileUpdate($data, $userid);
    public function laboratoryProfileUpdate($data, $userid);
    public function insuranceCompanyProfileUpdate($data, $userid);

    public function setVisitingHours($visitingHours, $profileID, $roleSlug);
}
