<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        // User::where('role_id',2)->delete();

        User::select('*')->delete();
        Role::select('*')->delete();
        Permission::select('*')->delete();

        Role::create(['id' => 1,'name' => 'Admin']);
        Role::create(['id' => 2,'name' => 'User']);
        
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'role_id' => 1,
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'role_id' => 2,
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);
        
    }

}
