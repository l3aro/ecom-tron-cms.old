<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            seed_user_table::class,
            seed_role_table::class,
            seed_setting_table::class,
            seed_lang_table::class
        ]);
    }
}
