<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
          'Физ лицо',
          'ИП',
          'ТОО',
          'АО'
        ];
        foreach ($data as $d){
            DB::table('user_types')->insertGetId([
               'name' => $d,
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now(),
            ]);
        }
    }
}
