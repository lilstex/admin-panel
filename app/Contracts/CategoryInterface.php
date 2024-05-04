<?php

namespace App\Contracts;

interface CategoryInterface {

    public function all();

    public function create(array $data);

    public function show($id);

    public function update($id, array $data);

    public function updateStatus(array $data);

    public function delete($id);

}