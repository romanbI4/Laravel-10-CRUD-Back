<?php

namespace Database\Seeders;

use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersIDs = DB::table('users')->pluck('id');

        DB::table('companies')->insert([
            'user_id' => $usersIDs->random(),
            'title' => Str::random(25),
            'phone' => (new Number)->numberBetween(),
            'description' => Str::random(50),
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
    }
}
