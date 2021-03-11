<?php

namespace Modules\User\Repositories;

interface DocumentRepository
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
    
    public function uploadDocuments($files, $role, $profileId, $doctype);
}
