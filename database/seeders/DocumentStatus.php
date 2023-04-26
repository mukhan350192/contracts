<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'В проверке',
            'Проверен юристами',
            'На корректировке',
            'Подтвержден'
        ];
        \App\Models\DocumentStatus::truncate();
        foreach ($data as $d) {
            \App\Models\DocumentStatus::create([
                'name' => $d,
            ]);
        }
    }
}
