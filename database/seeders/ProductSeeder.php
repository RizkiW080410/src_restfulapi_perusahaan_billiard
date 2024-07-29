<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timstamp = \Carbon\Carbon::now()->toDateString();
        DB::table('products')->insert([
            'name' => 'indomie goreng',
            'description' => 'indomie plus telur',
            'price' => 10000.00,
            'stock' => 30,
            'category' => 'makanan',
            'created_at' => $timstamp,
            'updated_at' => $timstamp,]);
    }
}
