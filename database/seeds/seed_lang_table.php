<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class seed_lang_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lang')->insert(
            array(
                'id' => 1,
                'name' => 'Tiếng Việt',
                'short_name' => 'vi',
                'image' => 'vi.jpg',
                'updated_by' => '1',
            )
        );
        DB::table('lang')->insert(
            array(        
                'id' => 2,
                'name' => 'moderator', 
                'short_name' => 'en', 
                'image' => 'en.jpg',
                'updated_by' => '1',
         )
        );

    }
}
