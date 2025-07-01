<?php

namespace Database\Seeders;

use App\Enums\SettingsEnum;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */use WithoutModelEvents;
    public function run(): void
    {
        Setting::updateOrCreate([
            'key' => SettingsEnum::GMAIL_ACCESS_TOKEN->value,
        ], [
            'value' =>config('services.gmail.access_token'),
        ]);
    }
}
