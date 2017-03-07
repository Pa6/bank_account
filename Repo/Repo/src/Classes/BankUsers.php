<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 06/03/2017
 * Time: 23:37
 */
namespace Repo\Classes;

use App\Balance;

class BankUsers extends BankBaseClass{

    function model()
    {
        return 'App\User';
    }

    public function all(){
        $this->instance = $this->model->get();
        return $this->instance;
    }

    public function create(array $data){
        $customer= $this->model->create($data);
        return $this->initialBalance($customer);
    }
    public function show($id){

        return $this->model->findOrFail($id);
    }

    public function update($id, array $data){
        $this->instance = $this->model->findOrFail($id);
        $this->instance->update($data);
        return $this->instance;
    }

    public function delete($id)
    {
        $this->instance = $this->model->findOrFail($id);
        $this->instance->delete();
        return ['message'=>'model instance successfully deleted'];
    }

    private function initialBalance($customer){
        Balance::create(['user_id' => $customer->id, 'balance_money' => 0]);
        return $customer;

    }
}








































































































/*
 * by Pascal
 */

