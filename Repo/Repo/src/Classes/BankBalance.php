<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 08/03/2017
 * Time: 09:56
 */

namespace Repo\Classes;


class BankBalance extends BankBaseClass
{

    function model()
    {
        return 'App\Balance';
    }

    public function all(){
        $this->instance = $this->model->with('user')->get();
        return $this->instance;
    }

    public function show($id){

        return $this->model->findOrFail($id);
    }
}