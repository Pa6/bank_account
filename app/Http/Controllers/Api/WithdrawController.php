<?php

namespace App\Http\Controllers\Api;

use App\Balance;
use App\Exceptions\CustomModelNotFoundException;
use App\Withdraw;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Repo\Facades\BankWithdraw;

class WithdrawController extends Controller
{
    private $withdraw= [];

    /**
     * Documentation Block
     * @api {get} /api/v1/withdraw Get all withdraw
     * @apiName Get-all-Withdraw
     * @apiGroup Withdraws
     * @apiSuccess {array} Success-Response  On success returns an array containing withdraw object
     */
    public function index(){
        return JsonResponse::create(BankWithdraw::all(),200);
    }

    /**
     * Documentation Block
     * @api {post} /api/v1/withdraw Create a withdraw
     * @apiName Create-a-withdraw
     * @apiGroup Withdraws
     * @apiParam (Fields) {Integer} user_id Mandatory user_id field
     * @apiParam (Fields) {Integer} amount Mandatory amount field
     * @apiSuccess {object} Success-Response  On success returns an object of the created transaction.
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     */
    public function store(Request $request){

        $rules = ['user_id' => 'required|numeric', 'amount' => 'required|numeric|max:20000'];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }

        $date = date("Y-m-d");

        $withdraw = Withdraw::Select(DB::raw('sum(amount) as total_withdraw'))
                                ->where('date', $date)
                                ->where('user_id',$request['user_id'])
                                ->first();

        $frequency = Withdraw::where('date',$date)
                    ->where('user_id',$request['user_id'])
                    ->count();

        $balance = Balance::where('user_id', $request['user_id'])->first();
        //number of frequency 3
        if($frequency >= 3){
            return response()->json(['error' => 'bad_request', 'message' => 'number_to_withdraw_per_day_exceed'],400);
        }
        elseif ($withdraw->total_withdraw >= 50000){
            return response()->json(['error' => 'bad_request', 'message' => 'total_amount_to_withdraw_reached'],400);
        }elseif($balance->balance_money < $request['amount']){
            return JsonResponse::create(['error' => 'bad_request', 'message' => 'low_balance'],400);
        }
        return JsonResponse::create(BankWithdraw::create($request->all()),200);
    }

    /**
     * Documentation Block
     * @api {get} /api/v1/withdraw/{id} Get a withdraw
     * @apiName Get-a-withdraw
     * @apiGroup Withdraws
     * @apiParam (Fields) {Integer} ID Withdraw id as url parameter
     * @apiSuccess {object} Success-Response  On success returns an object of the withdraw.
     * @apiError (404) {object} Not-found If a withdraw with id is not found. the api returns a not found response
     */
    public function show($id)
    {
        try {
            $this->withdraw = BankWithdraw::show($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->withdraw);
    }

    /**
     * Documentation Block
     * @api {put} /api/v1/withdraws/{id} Update a withdraw
     * @apiName Update-a-withdraws
     * @apiGroup Withdraws
     * @apiParam (Fields) {Integer} user_id Mandatory user_id field
     * @apiParam (Fields) {Integer} amount Mandatory amount field
     * @apiSuccess {object} Success-Response  On success returns an object of the updated transaction.
     * @apiError (404) {object} Not-found If a withdraw with id is not found. the api returns a not found response
     */
    public function update(Request $request, $id)
    {
        $rules = ['user_id' => 'required|numeric', 'amount' => 'required|numeric|max:20000'];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }

        try{
            $this->withdraw = BankWithdraw::update($id,$request->all());
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->withdraw,200);
    }


    /**
     * Documentation Block
     * @api {delete} /api/v1/withdraws/{id} Delete withdraw.
     * @apiName Delete-withdraws
     * @apiGroup  Withdraws
     * @apiSuccess {object} Success-Response  On success returns a success message
     * @apiError (404) {object} Not-Found  returns <code>not found</code> if transaction with the id does'nt exist
     */
    public function destroy($id){
        try{
            $this->object = BankWithdraw ::delete($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->object);
    }
}
