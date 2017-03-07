<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 07/03/2017
 * Time: 21:49
 */

namespace Repo\Facades;


use Illuminate\Support\Facades\Facade;

class BankDeposit extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'bank_deposit';
    }
}