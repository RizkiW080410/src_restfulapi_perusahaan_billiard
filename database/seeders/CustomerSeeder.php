<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timstamp = \Carbon\Carbon::now()->toDateString();
        DB::table('customers')->insert([
            'full_name' => 'rizki wahyu',
            'username' => 'wahyu123',
            'email' => 'wahyu123@gmail.com',
            'phone_number' => '081572665542',
            'created_at' => $timstamp,
            'updated_at' => $timstamp,]);
    }
}
