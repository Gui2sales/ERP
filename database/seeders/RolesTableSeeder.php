<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        
        DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Analista Financeiro',
                'guard_name' => 'web',
                'ativo' => 1,
                'created_at' => '2025-11-24 19:23:01',
                'updated_at' => '2025-12-02 20:29:37',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'Usuário Padrão',
                'guard_name' => 'web',
                'ativo' => 1,
                'created_at' => '2025-11-26 18:34:46',
                'updated_at' => '2025-12-02 20:26:51',
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'Guest',
                'guard_name' => 'web',
                'ativo' => 0,
                'created_at' => '2025-12-01 22:05:23',
                'updated_at' => '2025-12-03 17:48:05',
            ),
            3 => 
            array (
                'id' => 9,
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'ativo' => 1,
                'created_at' => '2025-12-04 19:56:42',
                'updated_at' => '2025-12-04 19:57:57',
            ),
        ));
    }
}