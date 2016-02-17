<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        DB::table('gateways')->insert([
        	'identification' => 'ecocashmerchant',
            'balance' => 10.00,
            'audit' => false,
        ]);
    }
}
