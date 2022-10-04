<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!CompanySetting::exists()) {
            $setting = new CompanySetting();
            $setting->company_name = 'Ninja Company';
            $setting->company_email = 'ninja@gmail.com';
            $setting->company_phone = '09775860845';
            $setting->company_address = 'Yangon';
            $setting->company_start_time = '09:00';
            $setting->company_end_time = '05:00';
            $setting->break_start_time = '12:30';
            $setting->break_end_time = '01:30';
            $setting->save();
        }
    }
}
