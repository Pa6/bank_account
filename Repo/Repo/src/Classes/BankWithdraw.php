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
        $this->instance = $this->model->select(DB::raw('sum(amount) as total_deposit'), 'number_per_day')
            ->where('date', $date)->where('user_id',$data['user_id'])->first();

        $balance = Balance::where('user_id',$data['user_id'])->first();
        //number of frequency 3
        if($this->instance->number_per_day == 3){
            return response()->json(['error' => 'bad_request'],400);
        }
        //max withdraw per day = 50kusd
        elseif ($this->instance->total_deposit >= 50000){
            return response()->json(['error' => 'bad_request'],400);
        }
        //cant withdraw large amount than he has
        elseif ($balance->balance_money < $data['amount']){
            return response()->json(['error' => 'bad_request'],400);
        }
        $data['number_per_day'] = $this->instance->number_per_day++;
        //max withdraw per transaction 20kusd


        $data['date'] = $date;

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

        //decrease the balance it is withdraw
            $balance->balance_money = $balance->balance_money - $transaction->amount;
            $balance->save();
            return $transaction;
    }
}