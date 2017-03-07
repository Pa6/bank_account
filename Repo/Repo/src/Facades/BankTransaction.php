<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 07/03/2017
 * Time: 13:19
 */

namespace Repo\Facades;


use Illuminate\Support\Facades\Facade;

class BankTransaction extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'bank_transaction';
    }
}