<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepositSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deposits')->truncate();
        $data = [
            'date'              => '2017/03/08',
            'user_id'           => 1,
            'amount'            => 20000,
            'number_per_day'    => 1,
            'status'            => 1,
            'currency'          => 'USD',
        ];
        \App\Deposit::create($data);
    }
}
