<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Guilherme Sales Cezaretto',
                'email' => 'ti023@pabu.com.br',
                'user' => '9972',
                'remember_token' => 'tkKTVIRLjr7VBRLhn2W6NuyIulCE0OMMmbZDkwsb3GRo7U2evdBAPkzX00km',
                'created_at' => '2025-11-21 16:46:11',
                'updated_at' => '2026-03-06 16:56:37',
                'ativo' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Leonardo Prates',
                'email' => 'ti015@pabu.com.br',
                'user' => '9943',
                'remember_token' => NULL,
                'created_at' => '2025-11-24 14:42:26',
                'updated_at' => '2025-12-02 22:12:31',
                'ativo' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Cesar Augusto Gaspar',
                'email' => 'cesar.gaspar@pabu.com.br',
                'user' => '9903',
                'remember_token' => NULL,
                'created_at' => '2025-12-15 14:33:05',
                'updated_at' => '2025-12-15 14:33:05',
                'ativo' => 1,
            ),
        ));
    }
}