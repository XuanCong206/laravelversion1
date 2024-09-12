<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      // Tạo cứng ra 1 bản ghi.
      // DB::table("users")->insert([
      //       'name' => 'Newbie Laravel',
			// 'email' => 'nguyenxuancongme@gmail.com',
			// 'password' => Hash::make('password'),
      // ]);

      // Fake 100 000 bản ghi.
      $this->call([
        UserSeeder::class
      ]);
    }
}
