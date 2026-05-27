<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
    
        DB::table('areas')->delete();
        
        DB::table('areas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nome' => 'Adm',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nome' => 'AGP',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nome' => 'Cadastro',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nome' => 'Cobrança',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nome' => 'Compras',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nome' => 'Crédito',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'nome' => 'Contabil',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nome' => 'Fiscal',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'nome' => 'Garantia',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'nome' => 'Inteligêngia',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'nome' => 'Logistica',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'nome' => 'Marketing',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'nome' => 'N1',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'nome' => 'RH',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'nome' => 'TI',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'nome' => 'Vendas',
                'responsavel' => NULL,
                'ativa' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}