<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{   
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(RolesSeeder::class);
         $this->call(ModelHasRolesSeeder::class);
        
         $this->call(PermissionsTableSeeder::class);
         $this->call(RoleHasPermissions::class);
         $this->call(MenusTableSeeder::class);
        
    }
}
