<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 07/03/2017
 * Time: 20:18
 */

namespace Repo\Classes;


use App\Balance;
use Illuminate\Support\Facades\DB;

class BankDeposit extends BankBaseClass
{

    function model()
    {
        return 'App\Deposit';
    }


    public function all(){
        $this->instance = $this->model->get();
        return $this->instance;
    }


    public function create(array $data)
    {
        $date = date("Y-m-d");
            $data['date'] = $date;
            $transaction = $this->model->create($data);
            return $this->adjustBalance($transaction);
    }
    public function show($id){

        return $this->model->findOrFail($id);
    }

    public function update($id, array $data){

        $balance = Balance::where('user_id',$data['user_id'])->first();

        $this->instance = $this->model->findOrFail($id);
        $difference = $data['amount'] - $this->instance->amount ;
        $this->instance->update($data);
        //increase the balance
        $balance->balance_money = $balance->balance_money + $difference;
        $balance->save();
        return $this->instance;
    }

    public function delete($id)
    {
        $this->instance = $this->model->findOrFail($id);
        $this->instance->delete();
        return ['message'=>'model instance successfully deleted'];
    }

    private function adjustBalance($transaction){
        $balance = Balance::where('user_id',$transaction->user_id)->first();
            //increase the balance
            $balance->balance_money = $balance->balance_money + $transaction->amount;
            $balance->save();
            return $transaction;
    }
}



































































/*
 * By Pascal developer
 */