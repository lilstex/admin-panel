<?php

namespace App\Contracts;

interface CmsInterface {

    public function all();

    public function create(array $data);

    public function show($id);

    public function update($id, array $data);

    public function updateStatus(array $data);

    public function delete($id);

}