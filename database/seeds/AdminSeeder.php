<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('admins')->insert([
             'username'=> 'admin',
	         'email' => 'admin@gmail.com',
	         'password' => bcrypt('password'),
	         'is_active' => 1,
	         'remember_token' => Str::random(10),
	         // 'user_type' => 1 ,
	         // 'user_id' => 1
        ]);
          DB::table('admins')->insert([
             'username'=> 'admin1',
	         'email' => 'admin1@gmail.com',
	         'password' => bcrypt('password'),
	         'is_active' => 0,
	         'remember_token' => Str::random(10),
	         // 'user_type' => 1 ,
	         // 'user_id' => 1
        ]);
        //   DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => bcrypt('password'),
        // ]);
    }
}