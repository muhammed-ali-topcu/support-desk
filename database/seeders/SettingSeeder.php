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
            'value' => '{
  "access_token": "ya29.a0AS3H6NwPDoHHLOvwYmEjmLNvy8D7vUZB3LZmzzhLnko0IOt72Zlvp8fG2N4hxRx7mebM4B_0ysfgsOk8c3yuClWek8idqu4hfOdmXgCfOy7Lshe9ciXUtHgTquMpmiRqL2_Q3cqPKGzvAdh2wHwkhqyEW2zWHKdYqjtad7ihaCgYKAecSAQ8SFQHGX2MibPcCgsxZ0Ul70DH7LlTL5A0175",
  "expires_in": 3599,
  "refresh_token": "1//03OrO7RWTSCd9CgYIARAAGAMSNwF-L9IrXjuX4vFFA89Btt8fWaAUBJGwEowC-skNvjvdPY2O2RMeQVHQ3z-yeQ82FclG2d5aPwA",
  "scope": "https://www.googleapis.com/auth/gmail.labels https://www.googleapis.com/auth/gmail.readonly",
  "token_type": "Bearer",
  "refresh_token_expires_in": 604799,
  "created": 1751376040
}',
        ]);
    }
}
