<?php
namespace Repo\Providers;
use Illuminate\Support\ServiceProvider;
use Repo\Classes\BankBalance;
use Repo\Classes\BankDeposit;
use Repo\Classes\BankTransaction;
use Repo\Classes\BankTransactionType;
use Repo\Classes\BankUsers;
use Illuminate\Container\Container as App;
use Repo\Classes\BankWithdraw;

/**
 * Created by PhpStorm.
 * User: pa6
 * Date: 06/03/2017
 * Time: 23:29
 */

class BankServiceProvider extends ServiceProvider{
    public function boot()
    {
        //
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Users
        $this->app->bind('bank_users',function(App $app){
            return new BankUsers($app);
        });

        //Transaction type
        $this->app->bind('bank_transaction_type',function(App $app){
            return new BankTransactionType($app);
        });

        //Transaction
        $this->app->bind('bank_transaction', function(App $app){
            return new BankTransaction($app);
        });

        //Deposit
        $this->app->bind('bank_deposit', function(App $app){
            return new BankDeposit($app);
        });

        //Withdraw
        $this->app->bind('bank_withdraw', function(App $app){
            return new BankWithdraw($app);
        });

        //Balance
        $this->app->bind('bank_balance', function(App $app){
            return new BankBalance($app);
        });
    }
}