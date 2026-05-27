<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuscaTelasIndexTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('busca_telas_index')->delete();
        
        DB::table('busca_telas_index')->insert(array (
            0 => 
            array (
                'id' => 1,
                'NOME' => "Administração do Sistema",
                'NOME_EXIBIDO' => 'Administração do Sistema',
                'ROTA' => 'usuarios',
                'SIGLA' => '0',
                'ATIVO' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'NOME' => "T.I.",
                'NOME_EXIBIDO' => 'T.I.',
                'ROTA' => 'ti',
                'SIGLA' => 'Y',
                'ATIVO' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'NOME' => "DHO",
                'NOME_EXIBIDO' => 'DHO',
                'ROTA' => 'dho',
                'SIGLA' => 'H',
                'ATIVO' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'NOME' => "Suprimentos",
                'NOME_EXIBIDO' => 'Suprimentos',
                'ROTA' => 'suprimentos',
                'SIGLA' => 'V',
                'ATIVO' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'NOME' => "Cotação",
                'NOME_EXIBIDO' => 'Suprimentos > Cotação',
                'ROTA' => 'Aprova Cotação',
                'SIGLA' => 'VC',
                'ATIVO' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'NOME' => "Chamados",
                'NOME_EXIBIDO' => 'T.I. > Chamados',
                'ROTA' => 'chamados',
                'SIGLA' => '',
                'ATIVO' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'NOME' => "Missões",
                'NOME_EXIBIDO' => 'T.I. > Missões',
                'ROTA' => 'missoes',
                'SIGLA' => '',
                'ATIVO' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'NOME' => "Banco de Talentos",
                'NOME_EXIBIDO' => 'DHO > Banco de Talentos',
                'ROTA' => 'Banco de Talentos',
                'SIGLA' => NULL,
                'ATIVO' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'NOME' => "Menus",
                'NOME_EXIBIDO' => 'Administração > Menus',
                'ROTA' => 'menus',
                'SIGLA' => NULL,
                'ATIVO' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'NOME' => "Perfis",
                'NOME_EXIBIDO' => 'Administração > Perfis',
                'ROTA' => 'perfis',
                'SIGLA' => NULL,
                'ATIVO' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'NOME' => "Gestão",
                'NOME_EXIBIDO' => 'T.I. > Gestão',
                'ROTA' => 'gestao',
                'SIGLA' => NULL,
                'ATIVO' => 1,
            ),
        ));
    }
}