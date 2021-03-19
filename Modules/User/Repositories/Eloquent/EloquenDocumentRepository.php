<?php

namespace Modules\User\Repositories\Eloquent;

use App\Helpers\CustomHelper;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Document;
use Modules\User\Entities\DocumentType;
use Modules\User\Repositories\DocumentRepository;

class EloquentDocumentRepository implements DocumentRepository
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Document $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Upload documents
     *
     * @param array $files
     * @param string $role
     * @param integer $profileId
     * @param string $doctype
     * @return boolean
     */
    public function uploadDocuments($files, $role, $profileId, $documentType)
    {
        $now = Carbon::now();
        //multiple uploads
        if ($files) {
            $docType = DocumentType::where('DocumentTypeName', $documentType)->first();
            $profileKey = CustomHelper::getProfileIdKey($role);           
            $uploadedFiles = [];
            foreach ($files as $file) {
                $fileName = $file->hashName();
                $path = $file->storeAs('documents/'.$documentType, $fileName,'public');
                if ($path) {
                    $uploadedFiles[] =  array('DocumentTypeID' => $docType->DocumentTypeID, $profileKey => $profileId, 'DocumentFile' => $path, 'CreatedAt' => $now->toDateTimeString());
                }
            }
            if (!empty($uploadedFiles)) {
                Document::insert($uploadedFiles);
            }
            return true;
        }
        return false;
    }

}
