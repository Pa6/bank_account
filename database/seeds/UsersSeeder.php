<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create(['email' => 'admin@akokanya.com' , 'name' => 'admin user', 'password' => Hash::make('admin')]);
        User::create(['email' => 'manager@akokanya.com', 'name' => 'account manager', 'password' => Hash::make('manager')]);

    }
}
