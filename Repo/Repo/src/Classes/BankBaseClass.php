<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 06/03/2017
 * Time: 23:39
 */

namespace Repo\Classes;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class BankBaseClass implements BankClassInterface
{

    private $app;
    protected $model;
    protected $instance;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }
    abstract function model();

    public function makeModel(){
        $model = $this->app->make($this->model());
        if(!$model instanceof Model){
            throw new Exception("class{$this->model()} must be instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

    public function all(){
        return $this->model->all();
    }

    public function create(array $data){
        return $this->model->create($data);
    }


    public function show($id){
        return $this->model->findOrFail($id);
    }

    public function update($id, array $data){
        $this->instance = $this->model->findOrFail($id);
        $this->instance->update($data);
        return $this->instance;
    }

    public function delete($id){
        $this->instance = $this->model->findOrFail($id);
        $this->instance->delete();
        return ['message'=>'model instance successfully deleted'];
    }

    public function rules(){

    }
}




































































































































/*
 * Developed by Soft ninja Pascal Ngurinzira
 */