<?php
return [
    'roles' => [        
        'patient' => 'Patient',
        'hospital' => 'Hospital',
        'insurance_company' => 'InsuranceCompany',
        'lab' => 'Lab',
        'doctor' => 'Doctor',
        'ambulance' => 'Ambulance',
        'super_admin' => 'super_admin',
    ],
    
    'role_slugs' => [
        'super_admin' => 'super_admin',
        'patient' => 'patient',
        'hospital' => 'hospital',
        'insurance_company' => 'insurance_company',
        'lab' => 'lab',
        'doctor' => 'doctor',
        'ambulance' => 'ambulance',
    ],

    'device_types'=>['android','ios'],

    'account_status'=>[
        'active'=>'Active',
        'inactive'=>'Inactive'
    ],

    'document_types'=>[
        'image'=>'image',
        'registered_paper'=>'registered_paper',
        'driving_license'=>'driving_license',
    ],

];
