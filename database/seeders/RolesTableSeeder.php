<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        
            ['id' => 3, 'role_name' => 'reception'],
            ['id' => 4, 'role_name' => 'physician'],
            ['id' => 5, 'role_name' => 'medical tecnologist'],
            ['id' => 6, 'role_name' => 'radiologic technologist'],
            
        ]);
    }
}
