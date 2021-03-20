<?php
return [
    //this roles array use for role seeder
    'roles' => [        
        'patient' => 'Patient',
        'hospital' => 'Hospital',
        'insurance_company' => 'Insurance Company',
        'lab' => 'Lab',
        'doctor' => 'Doctor',
        'ambulance' => 'Ambulance',
        'super_admin' => 'Super Admin',      
    ],
    //for role seeder
    'roles_staff'=>[
        'hospital_medical_staff'=>'Hospital medical staff',
        'hospital_lab_staff'=>'Hospital lab staff',
        'hospital_ambulance_staff'=>'Hospital ambulance staff',
        'hospital_admin'=>'Hospital admin',

        'lab_schedule_staff'=>'Lab schedule staff',
        'lab_accountant_staff'=>'Lab accountant staff',
        'lab_admin'=>'Lab admin',

        'insurance_company_admin'=>'Insurance company admin',
        'insurance_company_sales_staff'=>'Insurance company sales staff',
        'insurance_company_accountant_staff'=>'Insurance company account staff'
    ],

    //this array used in code
    'role_slugs' => [
        'super_admin' => 'super_admin',
        'patient' => 'patient',
        'hospital' => 'hospital',
        'insurance_company' => 'insurance_company',
        'lab' => 'lab',
        'doctor' => 'doctor',
        'ambulance' => 'ambulance',

        'hospital_medical_staff'=>'hospital_medical_staff',
        'hospital_lab_staff'=>'hospital_lab_staff',
        'hospital_ambulance_staff'=>'hospital_ambulance_staff',
        'hospital_admin'=>'hospital_admin',

        'lab_schedule_staff'=>'lab_schedule_staff',
        'lab_accountant_staff'=>'lab_accountant_staff',
        'lab_admin'=>'lab_admin',

        'insurance_company_admin'=>'insurance_company_admin',
        'insurance_company_sales_staff'=>'insurance_company_sales_staff',
        'insurance_company_accountant_staff'=>'insurance_company_accountant_staff'
    ],

    'device_types'=>['android','ios'],
    'account_status'=>[
        'active'=>'Active',
        'inactive'=>'Inactive'
    ],

    'document_types'=>[
        'registered_paper'=>'registered_paper',
        'driving_license'=>'driving_license',
    ],
];
