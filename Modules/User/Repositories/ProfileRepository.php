<?php

namespace Modules\User\Repositories;

interface ProfileRepository
{
    //t public function createWithRoles($data,$role);
    // public function isAdmin($user);
    public function patientProfileUpdate(array $data,$userid);
    public function doctorProfileUpdate(array $data, $userid); 
    public function doctorProfileOnlyUpdate(array $data, $userid);
    
    public function hospitalProfileUpdate(array $data, $userid);
    public function ambulanceProfileUpdate(array $data, $userid);
    public function laboratoryProfileUpdate(array $data, $userid);
    public function insuranceCompanyProfileUpdate(array $data, $userid);
   

    public function setVisitingHours($visitingHours, $profileID, $roleSlug);
    public function setMedicalSectors($sectorIDs, $doctorID);
}
