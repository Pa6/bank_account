<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomModelNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Repo\Facades\BankTransaction;

class TransactionController extends Controller
{
    private $transaction= [];

    /**
     * Documentation Block
     * @api {get} /api/v1/transactions Get all transactions
     * @apiName Get-all-Transactions
     * @apiGroup Transactions
     * @apiSuccess {array} Success-Response  On success returns an array containing transaction object
     */
    public function index(){
        return JsonResponse::create(BankTransaction::all(),200);
    }


    /**
     * Documentation Block
     * @api {post} /api/v1/transactions Create a transaction
     * @apiName Create-a-transaction
     * @apiGroup Transactions
     * @apiParam (Fields) {Integer} user_id Mandatory user_id field
     * @apiParam (Fields) {String} date Optional date field
     * @apiParam (Fields) {Integer} transaction_type_id Mandatory transaction_type_id field
     * @apiParam (Fields) {Integer} amount Mandatory amount field
     * @apiSuccess {object} Success-Response  On success returns an object of the created transaction.
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     */
    public function store(Request $request){
        $rules = ['user_id' => 'required|numeric', 'date' => 'required', 'transaction_type_id' => 'required|numeric', 'amount' => 'required|numeric'];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }
        return JsonResponse::create(BankTransaction::create($request->all()),200);
    }

    /**
     * Documentation Block
     * @api {get} /api/v1/transactions/{id} Get a transaction
     * @apiName Get-a-transaction
     * @apiGroup Transactions
     * @apiParam (Fields) {Integer} ID Transaction id as url parameter
     * @apiSuccess {object} Success-Response  On success returns an object of the user.
     * @apiError (404) {object} Not-found If a transaction with id is not found. the api returns a not found response
     */
    public function show($id)
    {
        try{
            $this->transaction = BankTransaction::show($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->transaction);
    }


    /**
     * Documentation Block
     * @api {put} /api/v1/transactions/{id} Update a transaction
     * @apiName Update-a-transaction
     * @apiGroup Transactions
     * @apiParam (Fields) {Integer} user_id Mandatory user_id field
     * @apiParam (Fields) {String} date Optional date field
     * @apiParam (Fields) {Integer} transaction_type_id Mandatory transaction_type_id field
     * @apiParam (Fields) {Integer} amount Mandatory amount field
     * @apiSuccess {object} Success-Response  On success returns an object of the updated transaction.
     * @apiError (404) {object} Not-found If a transaction with id is not found. the api returns a not found response
     */
    public function update(Request $request){
        try{
            $this->transaction = BankTransaction::update($request->all());
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->transaction,200);
    }

    /**
     * Documentation Block
     * @api {delete} /api/v1/transactions/{id} Delete transaction.
     * @apiName Delete-transactions
     * @apiGroup  Transactions
     * @apiSuccess {object} Success-Response  On success returns a success message
     * @apiError (404) {object} Not-Found  returns <code>not found</code> if transaction with the id does'nt exist
     */
    public function destroy($id){
        try{
            $this->object = BankTransaction ::delete($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->object);
    }
}
