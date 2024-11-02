<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->select('*')->delete();

        $data = [
            ['field' => 'web_name', 'value' => 'Customs Software'],
            ['field' => 'web_logo', 'value' => 'logo'],
            ['field' => 'web_favicon','value' => 'logo.png'],

            ['field' => 'phone_number', 'value' => '+92000000000'],
            ['field' => 'email_address', 'value' => 'admin@admin.com'],
           
            ['field' => 'meta_title', 'value' => 'Customs Software'],
            ['field' => 'meta_description', 'value' => ''],
            ['field' => 'meta_keywords', 'value' => ''],
            
            ['field' => 'address', 'value' => 'Address Will come here.'],
            ['field' => 'domain', 'value' => 'www.yourdomain.com'],
        ];

        // General Settings
        foreach ($data as $key => $value) {
            $value['section'] = 'general_settings';
            DB::table('settings')->insert($value);
        }


        $data = [
            ['field' => 'primarry_color', 'value' => 'Customs Software'],
            ['field' => 'secondry_color', 'value' => 'logo'],
        ];
        
         // General Settings
         foreach ($data as $key => $value) {
            $value['section'] = 'theme_settings';
            DB::table('settings')->insert($value);
        }
        
    }
}
