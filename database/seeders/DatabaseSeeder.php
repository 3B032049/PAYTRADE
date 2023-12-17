<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Seller;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'password' => 'password',
            'sex' => '男',
            'birthday' => '2023/11/11',
            'phone' => '0987654321',
            'address' => 'Taoyuan',
        ])->each(function ($user) {
            // 創建相對應的管理員資料
            Seller::create([
                'user_id' => $user->id,
                'status' => 3, // 預設賣家為尚未審核
            ]);
        });

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'sex' => '男',
            'birthday' => '2023/11/27',
            'phone' => '0987654321',
            'address' => 'Taiwan',
        ])->each(function ($user) {
            // 創建相對應的管理員資料
            Admin::create([
                'user_id' => $user->id,
                'position' => 1, // 預設管理員的等級為1
            ]);
        });

        #建立10筆測試會員
        User::factory(10)->create();
    }
}
