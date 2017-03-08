<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomModelNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repo\Facades\BankBalance;

class BalanceController extends Controller
{
    private $balance = [];

    /**
     * Documentation Block
     * @api {get} /api/v1/balances Get all balances
     * @apiName Get-all-Balances
     * @apiGroup Balance
     * @apiSuccess {array} Success-Response  On success returns an array containing balance object
     */
    public function index(){
        return JsonResponse::create(BankBalance::all(),200);
    }


    /**
     * Documentation Block
     * @api {get} /api/v1/balances/{id} Get a  balance
     * @apiName Get-a-balance
     * @apiGroup Balances
     * @apiParam (Fields) {Integer} ID Balance id as url parameter
     * @apiSuccess {object} Success-Response  On success returns an object of the balance.
     * @apiError (404) {object} Not-found If a balance with id is not found. the api returns a not found response
     */
    public function show($id)
    {
        try{
            $this->balance  = BankBalance::show($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->balance);
    }

}
