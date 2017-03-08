<?php

use Illuminate\Database\Seeder;

class WithDrawSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('withdraws')->truncate();
        $data = [
            'date'              => '2017/03/08',
            'user_id'           => 1,
            'amount'            => 5000,
            'number_per_day'    => 1,
            'status'            => 1,
            'currency'          => 'USD',
        ];
        \App\Withdraw::create($data);
    }
}
