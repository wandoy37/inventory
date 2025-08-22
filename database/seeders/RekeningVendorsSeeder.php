<?php

namespace Database\Seeders;

use App\Models\RekeningVendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningVendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RekeningVendor::create([
            'vendor_id' => '1',
            'bank_name' => 'BCA',
            'rekening_number' => '11026027',
        ]);

        RekeningVendor::create([
            'vendor_id' => '1',
            'bank_name' => 'BNI',
            'rekening_number' => '18023024',
        ]);

        RekeningVendor::create([
            'vendor_id' => '1',
            'bank_name' => 'BRI',
            'rekening_number' => '2300500',
        ]);

        RekeningVendor::create([
            'vendor_id' => '2',
            'bank_name' => 'BNI',
            'rekening_number' => '18056057',
        ]);

        RekeningVendor::create([
            'vendor_id' => '2',
            'bank_name' => 'BRI',
            'rekening_number' => '23200800',
        ]);
    }
}
