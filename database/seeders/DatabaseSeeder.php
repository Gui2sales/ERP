<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(BuscaTelasIndexTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(ModulesTableSeeder::class);

        $this->call(ModelHasRolesTableSeeder::class);        
        $this->call(ModelHasPermissionsTableSeeder::class);
        // $this->call(RoleHasPermissionsTableSeeder::class);
    }
}
