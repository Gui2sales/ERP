<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->delete();
        
        DB::table('modules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nome' => 'Usuarios',
                'icone' => 'building-gear',
                'descricao' => 'Administração',
                'sistema' => '000',
                'ativo' => 1,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'nome' => 'TI',
                'icone' => 'laptop',
                'descricao' => 'T.I.',
                'sistema' => '000',
                'ativo' => 1,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 17,
                'nome' => 'dho',
                'icone' => 'people',
                'descricao' => 'DHO',
                'sistema' => '000',
                'ativo' => 0,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 18,
                'nome' => 'suprimentos',
                'icone' => 'cart-plus',
                'descricao' => 'Suprimentos',
                'sistema' => 'V',
                'ativo' => 1,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}