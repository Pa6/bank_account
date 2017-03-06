<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomModelNotFoundException;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Repo\Facades\BankUsers;

class UsersController extends Controller
{
    private $user = [];

    /**
     * Documentation Block
     * @api {get} /api/v1/users Get all users
     * @apiName Get-all-Users
     * @apiGroup Users
     * @apiSuccess {array} Success-Response  On success returns an array containing user objects
     */
    public function index(){
        return JsonResponse::create(BankUsers::all(),200);
    }

    /**
     * Documentation Block
     * @api {post} /api/v1/users Create a user
     * @apiName Create-a-user
     * @apiGroup Users
     * @apiParam (Fields) {String} name Mandatory name field
     * @apiParam (Fields) {String} phone Mandatory phone field
     * @apiParam (Fields) {String} email Mandatory Email field
     * @apiSuccess {object} Success-Response  On success returns an object of the created user.
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     */
    public function store(Request $request){
        $validation = Validator::make($request->all(),User::rules());
        if($validation->fails()){
            return JsonResponse::create($validation->messages(),422);
        }
        return JsonResponse::create(BankUsers::create($request->all()),200);
    }

    /**
     * Documentation Block
     * @api {get} /api/v1/users/{id} Get a user
     * @apiName Get-a-user
     * @apiGroup Users
     * @apiParam (Fields) {Integer} ID User id as url parameter
     * @apiSuccess {object} Success-Response  On success returns an object of the user.
     * @apiError (404) {object} Not-found If a user with id is not found. the api returns a not found response
     */
    public function show($id)
    {
        try{
            $this->user = BankUsers::show($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->user);
    }


    /**
     * Documentation Block
     * @api {put} /api/v1/users/{id} Update a user
     * @apiName Update-a-user
     * @apiGroup Users
     * @apiParam (Fields) {String} [name] Optional name field
     * @apiParam (Fields) {String} [phone] Optional phone field
     * @apiSuccess {object} Success-Response  On success returns an object of the updated user.
     * @apiError (404) {object} Not-found If a user with id is not found. the api returns a not found response
     */
    public function update(Request $request, $id){
        try{
            $this->user = BankUsers::update($id,$request->only('name','phone'));
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->user,200);
    }

    /**
     * Documentation Block
     * @api {delete} /api/v1/users/{id} Delete a user
     * @apiName Delete-a-user
     * @apiGroup Users
     * @apiParam (Fields) {Integer} ID User id as url parameter
     * @apiSuccess {object} Success-Response  On success returns success message.
     * @apiError (404) {object} Not-found If a user with id is not found. the api returns a not found response
     */
    public function destroy($id){
        try{
            $this->user = BankUsers::delete($id);
        }catch (ModelNotFoundException $e){
            throw new CustomModelNotFoundException();
        }
        return JsonResponse::create($this->user,200);
    }
}
