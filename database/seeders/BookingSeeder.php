<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timstamp = \Carbon\Carbon::now()->toDateString();
        DB::table('bookings')->insert([
            'customer_id' => 1,
            'meja_id' => 1,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addHours(2),
            'total_price' => 70000.00,
            'status' => 'booked',
            'created_at' => $timstamp,
            'updated_at' => $timstamp,]);
    }
}
