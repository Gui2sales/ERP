<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->delete();
        
        DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 1,
                'role_id' => 3,
            ),
            1 => 
            array (
                'permission_id' => 2,
                'role_id' => 3,
            ),
            2 => 
            array (
                'permission_id' => 3,
                'role_id' => 3,
            ),
            3 => 
            array (
                'permission_id' => 4,
                'role_id' => 3,
            ),
            4 => 
            array (
                'permission_id' => 4,
                'role_id' => 4,
            ),
            5 => 
            array (
                'permission_id' => 5,
                'role_id' => 3,
            ),
            6 => 
            array (
                'permission_id' => 6,
                'role_id' => 3,
            ),
            7 => 
            array (
                'permission_id' => 7,
                'role_id' => 2,
            ),
            8 => 
            array (
                'permission_id' => 7,
                'role_id' => 3,
            ),
            9 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            10 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            11 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            12 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            13 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            14 => 
            array (
                'permission_id' => 10,
                'role_id' => 4,
            ),
            15 => 
            array (
                'permission_id' => 11,
                'role_id' => 3,
            ),
            16 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            17 => 
            array (
                'permission_id' => 12,
                'role_id' => 4,
            ),
            18 => 
            array (
                'permission_id' => 12,
                'role_id' => 8,
            ),
            19 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            20 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            21 => 
            array (
                'permission_id' => 14,
                'role_id' => 4,
            ),
            22 => 
            array (
                'permission_id' => 14,
                'role_id' => 8,
            ),
            23 => 
            array (
                'permission_id' => 15,
                'role_id' => 3,
            ),
            24 => 
            array (
                'permission_id' => 15,
                'role_id' => 8,
            ),
            25 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            26 => 
            array (
                'permission_id' => 16,
                'role_id' => 4,
            ),
            27 => 
            array (
                'permission_id' => 19,
                'role_id' => 4,
            ),
        ));
    }
}