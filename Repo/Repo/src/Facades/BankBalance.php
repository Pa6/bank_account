<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 08/03/2017
 * Time: 09:59
 */

namespace Repo\Facades;


use Illuminate\Support\Facades\Facade;

class BankBalance extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'bank_balance';
    }
}