<?php

namespace App\Http\Controllers\Api;

use App\Deposit;
use App\Exceptions\CustomModelNotFoundException;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Repo\Facades\BankDeposit;

class DepositController extends Controller
{
    private $deposit= [];

    /**
     * Documentation Block
     * @api {get} /api/v1/deposits Get all deposits
     * @apiName Get-all-Deposits
     * @apiGroup Deposits
     * @apiSuccess {array} Success-Response  On success returns an array containing deposit object
     */
    public function index(){
        return JsonResponse::create(BankDeposit::all(),200);
    }


    /**
     * Documentation Block
     * @api {post} /api/v1/deposits Create a deposit
     * @apiName Create-a-deposit
     * @apiGroup Deposits
     * @apiParam (Fields) {Integer} user_id Mandatory user_id field
     * @apiParam (Fields) {Integer} amount Mandatory amount field
     * @apiSuccess {object} Success-Response  On success returns an object of the created transaction.
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     */
    public function store(Request $request){

        $rules = ['user_id' => 'required|numeric', 'amount' => 'required|numeric|max:40000'];

        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }

        $date = date("Y-m-d");

        $deposit = Deposit::Select(DB::raw('sum(amount) as total_deposit'), 'number_per_day')
            ->where('date', $date)->where('user_id',$request['user_id'])->first();

        $frequency = Deposit::where('date',$date)->where('user_id',$request['user_id'])->count();
        //number of frequency 4
        if($frequency >= 4){
            return response()->json(['error' => 'bad_request', 'message' => 'number_to_deposit_per_day_exceed'],400);
        }
        //check maximum deposit per day if reached 150K$
        elseif($deposit->total_deposit >= 150000){
            return response()->json(['error' => 'bad_request', 'message' => 'total_amount_to_deposit_reached'],400);
        }

        return JsonResponse::create(BankDeposit::create($request->all()),200);
    }

    /**
     * Documentation Block
     * @api {get} /api/v1/deposits/{id} Get a deposit
     * @apiName Get-a-deposit
     * @apiGroup Deposits
     * @apiParam (Fields) {Integer} ID Deposit id as url parameter
     * @apiSuccess {object} Success-Response  On success returns an object of the deposit.
     * @apiError (404) {object} Not-found If a deposit with id is not found. the api returns a not found response
     */
    public function show($id)
    {
        try {
            $this->deposit = BankDeposit::show($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->deposit);
    }

    /**
     * Documentation Block
     * @api {put} /api/v1/deposits/{id} Update a deposits
     * @apiName Update-a-deposits
     * @apiGroup Deposits
     * @apiParam (Fields) {Integer} user_id Mandatory user_id field
     * @apiParam (Fields) {Integer} amount Mandatory amount field
     * @apiSuccess {object} Success-Response  On success returns an object of the updated transaction.
     * @apiError (404) {object} Not-found If a deposit with id is not found. the api returns a not found response
     */
    public function update(Request $request, $id)
    {
        $rules = ['user_id' => 'required|numeric', 'amount' => 'required|numeric|max:40000'];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }

        try{
            $this->deposit = BankDeposit::update($id,$request->all());
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->deposit,200);
    }



    /**
     * Documentation Block
     * @api {delete} /api/v1/deposits/{id} Delete deposit.
     * @apiName Delete-deposit
     * @apiGroup  Deposits
     * @apiSuccess {object} Success-Response  On success returns a success message
     * @apiError (404) {object} Not-Found  returns <code>not found</code> if transaction with the id does'nt exist
     */
    public function destroy($id){
        try{
            $this->object = BankDeposit ::delete($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->object);
    }
}
