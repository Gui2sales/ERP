<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_permissions')->delete();
        
        DB::table('model_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            2 => 
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9,
            ),
            3 => 
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            4 => 
            array (
                'permission_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            5 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            6 => 
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            7 => 
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            8 => 
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 13,
            ),
            9 => 
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            10 => 
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 11,
            ),
            11 => 
            array (
                'permission_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            12 => 
            array (
                'permission_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            13 => 
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            14 => 
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            15 => 
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9,
            ),
            16 => 
            array (
                'permission_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            17 => 
            array (
                'permission_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            18 => 
            array (
                'permission_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 5,
            ),
            25 => 
            array (
                'permission_id' => 16,
                'model_type' => 'App\\Models\\Roles',
                'model_id' => 4,
            ),
            26 => 
            array (
                'permission_id' => 16,
                'model_type' => 'App\\Models\\User',
                'model_id' => 5,
            ),
        ));
    }
}