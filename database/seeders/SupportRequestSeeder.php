<?php

namespace Database\Seeders;

use App\Models\SupportRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupportRequest::factory()->count(10)->create();
    }
}
