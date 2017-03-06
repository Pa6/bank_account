<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 06/03/2017
 * Time: 23:37
 */
namespace Repo\Classes;

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
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'],
            'country' => $data['country'],
            'city' => $data['city'],
        ];

        return parent::create($data);

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
}

