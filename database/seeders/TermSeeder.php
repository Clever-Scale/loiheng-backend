<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting1 = Setting::create([
            'key'          =>  'term_and_condition',
            'value'         =>  'hi',
            'created_by'      =>  1,
        ]);
    }
}
