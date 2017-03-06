<?php
/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 06/03/2017
 * Time: 23:33
 */
namespace Repo\Facades;
use Illuminate\Support\Facades\Facade;

class BankUsers extends  Facade{
    public static function getFacadeAccessor()
    {
        return 'bank_users';
    }

}
