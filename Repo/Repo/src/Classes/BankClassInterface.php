<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 06/03/2017
 * Time: 23:57
 */

namespace Repo\Classes;


interface BankClassInterface
{
    public function all();

    public function create(array $data);

    public function show($id);

    public function update($id, array $data);

    public function delete($id);

    public function rules();
}





































































/*
 * Developed by Pascal
 */