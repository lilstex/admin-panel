<?php

namespace App\Contracts;

interface ProductInterface {

    public function all();

    public function subcategories();

    public function filter();

    public function create(array $data);

    public function show($id);

    public function update($id, array $data);

    public function updateStatus(array $data);

    public function delete($id);

    public function deleteImage($id);

    public function deleteVideo($id);

}