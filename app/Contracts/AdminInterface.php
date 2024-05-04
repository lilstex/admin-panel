<?php

namespace App\Contracts;

interface AdminInterface {

    public function all();

    public function register(array $data);

    public function login(array $data);

    public function changePassword(array $data);

    public function updateProfile(array $data);

    public function logout();

    public function show($id);

    public function getPermissions($id);

    public function update($id, array $data);

    public function updateStatus(array $data);

    public function updateRoles(array $data);

    public function delete($id);

}