<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

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
            ['field' => 'primary_color', 'value' => '#0e2843'],
            ['field' => 'secondry_color', 'value' => '#0ea396'],
        ];
        
         // General Settings
         foreach ($data as $key => $value) {
            $value['section'] = 'theme_settings';
            DB::table('settings')->insert($value);
        }

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
