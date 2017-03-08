<?php

use App\Balance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balances')->truncate();
        $balance = [
            'balance_money' => 20000,
            'user_id' => 1,
        ];
        Balance::create($balance);
    }
}
