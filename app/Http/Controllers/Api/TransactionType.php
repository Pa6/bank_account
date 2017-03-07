<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomModelNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Repo\Facades\BankTransactionType;

class TransactionType extends Controller
{
    private $transaction_type = [];

    /**
     * Documentation Block
     * @api {get} /api/v1/transaction-types Get all transaction types
     * @apiName Get-all-Transaction-Types
     * @apiGroup TransactionTypes
     * @apiSuccess {array} Success-Response  On success returns an array containing transaction-type object
     */
    public function index(){
        return JsonResponse::create(BankTransactionType::all(),200);
    }


    /**
     * Documentation Block
     * @api {post} /api/v1/transaction-types Create a transaction type
     * @apiName Create-a-transaction-type
     * @apiGroup TransactionTypes
     * @apiParam (Fields) {String} name Mandatory name field
     * @apiParam (Fields) {String} description Optional description field
     * @apiSuccess {object} Success-Response  On success returns an object of the created transaction-type.
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     */
    public function store(Request $request){
        $rules = ['name' => 'required'];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }
        return JsonResponse::create(BankTransactionType::create($request->all()),200);
    }

    /**
     * Documentation Block
     * @api {get} /api/v1/transaction-types/{id} Get a transaction type
     * @apiName Get-a-transaction-type
     * @apiGroup TransactionTypes
     * @apiParam (Fields) {Integer} ID TransactionType id as url parameter
     * @apiSuccess {object} Success-Response  On success returns an object of the user.
     * @apiError (404) {object} Not-found If a transaction with id is not found. the api returns a not found response
     */
    public function show($id)
    {
        try{
            $this->transaction_type  = BankTransactionType::show($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->transaction_type);
    }


    /**
     * Documentation Block
     * @api {put} /api/v1/transaction-types/{id} Update a transaction type
     * @apiName Update-a-transaction-type
     * @apiGroup TransactionTypes
     * @apiParam (Fields) {String} [name] Optional name field
     * @apiParam (Fields) {String} [description] Optional description field
     * @apiSuccess {object} Success-Response  On success returns an object of the updated transaction type.
     * @apiError (404) {object} Not-found If a transaction type with id is not found. the api returns a not found response
     */
    public function update(Request $request, $id){
        try{
            $this->transaction_type = BankTransactionType::update($id,$request->only('name','description'));
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->transaction_type,200);
    }

    /**
     * Documentation Block
     * @api {delete} /api/v1/transaction-types/{id} Delete transaction type.
     * @apiName Delete-transaction-type
     * @apiGroup  TransactionTypes
     * @apiSuccess {object} Success-Response  On success returns a success message
     * @apiError (404) {object} Not-Found  returns <code>not found</code> if transaction-type with the id does'nt exist
     */
    public function destroy($id){
        try{
            $this->object = BankTransactionType::delete($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->object);
    }
}
