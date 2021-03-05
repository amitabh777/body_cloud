<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\DocumentType;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $docTypes = config('user.const.document_types');       
        foreach($docTypes as $type){
            $row = array('DocumentTypeName'=>$type,'DocumentTypeDesc'=>'test');
             DocumentType::create($row);
        }
        // $this->call("OthersTableSeeder");
    }
}
