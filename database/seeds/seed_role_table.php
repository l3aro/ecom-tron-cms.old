<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;

class seed_role_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert(
            array(
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Can manage all aspects of the Page.'
            )
        );
        DB::table('roles')->insert(
            array(        
                'id' => 2,
                'name' => 'moderator', 
                'display_name' => 'Moderator', 
                'description' => 'mod_descript'
         )
        );
        DB::table('roles')->insert(
            array(        
                'id' => 3,
                'name' => 'editor', 
                'display_name' => 'Editor', 
                'description' => 'editor_descript'
            )
        );
        DB::table('roles')->insert(
            array(        
                'id' => 4,
                'name' => 'publisher', 
                'display_name' => 'Publisher', 
                'description' => 'publisher_descript'
            )
        );

        $mod = Role::where('name', 'admin')->first();
        $user = User::find(1);
        $user->attachRole($mod);
    }
}
