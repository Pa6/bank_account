<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 07/03/2017
 * Time: 20:13
 */

namespace Repo\Classes;


use App\Balance;
use Illuminate\Support\Facades\DB;

class BankWithdraw extends BankBaseClass
{

    function model()
    {
        return 'App\Withdraw';
    }


    public function all(){
        $this->instance = $this->model->with('user')->get();
        return $this->instance;
    }


    public function create(array $data){

        $date = date("Y-m-d");
        $data['number_per_day'] = 1;

        $data['date'] = $date;

        $this->instance = $this->model->create($data);
        return $this->adjustBalance($this->instance);
    }
    public function show($id){

        return $this->model->findOrFail($id);
    }

    public function update($id, array $data){

        $balance = Balance::where('user_id',$data['user_id'])->first();
        $this->instance = $this->model->findOrFail($id);
        $this->instance->update($data);
        $balance->balance_money = $balance->balance_money + $data['amount'];
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

        //decrease the balance it is withdraw
            $balance->balance_money = $balance->balance_money - $transaction->amount;
            $balance->save();
            return $transaction;
    }
}








































































/*
 *
 * Pa dev
 */