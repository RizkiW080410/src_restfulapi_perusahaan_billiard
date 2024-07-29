<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timstamp = \Carbon\Carbon::now()->toDateString();
        DB::table('mejas')->insert([
            'name' => 'meja 1',
            'status' => 'available',
            'created_at' => $timstamp,
            'updated_at' => $timstamp,]);
    }
}
