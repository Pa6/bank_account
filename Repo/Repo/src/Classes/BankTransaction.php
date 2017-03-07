<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 07/03/2017
 * Time: 13:13
 */

namespace Repo\Classes;


use App\Balance;

class BankTransaction extends BankBaseClass
{

    function model()
    {
        return 'App\Transaction';
    }


    public function all(){
        $this->instance = $this->model->get();
        return $this->instance;
    }


    public function create(array $data){
         $transaction = $this->model->create($data);
         return $this->adjustBalance($transaction);
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

    private function adjustBalance($transaction){
        $balance = Balance::where('user_id',$transaction->user_id)->first();

       // echo json_encode($balance); exit();
        if($transaction->transaction_type_id == 1){
            //increase the balance
            $balance->balance_money = $balance->balance_money + $transaction->amount;
            $balance->save();
            return $transaction;
        }else{
            //decrease the balance it is withdraw
            $balance->balance_money = $balance->balance_money - $transaction->amount;
            $balance->save();
            return $transaction;
        }
    }
}