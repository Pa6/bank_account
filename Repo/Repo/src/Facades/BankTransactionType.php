<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 07/03/2017
 * Time: 11:32
 */

namespace Repo\Facades;


use Illuminate\Support\Facades\Facade;

class BankTransactionType extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'bank_transaction_type';
    }
}