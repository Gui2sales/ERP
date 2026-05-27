<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        
        DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin.roles.index',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:09:06',
                'updated_at' => '2025-11-24 17:09:06',
                'modulo_id' => 1,
                'tela_id' => 3,
                'funcao' => '',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin.roles.create',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:09:41',
                'updated_at' => '2025-11-24 17:09:41',
                'modulo_id' => 1,
                'tela_id' => 3,
                'funcao' => 'Criar',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'admin.roles.edit',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:09:41',
                'updated_at' => '2025-11-24 17:09:41',
                'modulo_id' => 1,
                'tela_id' => 3,
                'funcao' => 'Editar',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'admin.roles.delete',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:09:41',
                'updated_at' => '2025-11-24 17:09:41',
                'modulo_id' => 1,
                'tela_id' => 3,
                'funcao' => 'Deletar',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'admin.users.index',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:09:41',
                'updated_at' => '2025-11-24 17:09:41',
                'modulo_id' => 1,
                'tela_id' => 2,
                'funcao' => '',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'admin.users.edit',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:09:41',
                'updated_at' => '2025-11-24 17:09:41',
                'modulo_id' => 1,
                'tela_id' => 2,
                'funcao' => 'Editar',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'financeiro',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:47:03',
                'updated_at' => '2025-11-24 17:47:03',
                'modulo_id' => 2,
                'tela_id' => 4,
                'funcao' => '',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'financeiro.credito',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:47:13',
                'updated_at' => '2025-11-24 17:47:13',
                'modulo_id' => 2,
                'tela_id' => 6,
                'funcao' => '',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'financeiro.sod',
                'guard_name' => 'web',
                'created_at' => '2025-11-24 17:47:22',
                'updated_at' => '2025-11-24 17:47:22',
                'modulo_id' => 2,
                'tela_id' => 1,
                'funcao' => '',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2025-11-25 20:38:09',
                'updated_at' => '2025-11-25 20:38:09',
                'modulo_id' => 1,
                'tela_id' => 5,
                'funcao' => '',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'ti',
                'guard_name' => 'web',
                'created_at' => '2025-11-26 13:59:28',
                'updated_at' => '2025-11-26 13:59:28',
                'modulo_id' => 3,
                'tela_id' => 0,
                'funcao' => '',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'rh',
                'guard_name' => 'web',
                'created_at' => '2025-12-03 16:25:53',
                'updated_at' => '2025-12-03 16:25:53',
                'modulo_id' => 17,
                'tela_id' => 0,
                'funcao' => '',
            ),
            16 => 
            array (
                'id' => 19,
                'name' => 'admin.menus',
                'guard_name' => 'web',
                'created_at' => '2025-12-05 20:00:05',
                'updated_at' => '2025-12-05 20:00:05',
                'modulo_id' => 1,
                'tela_id' => 3,
                'funcao' => ' ',
            ),
        ));
    }
}