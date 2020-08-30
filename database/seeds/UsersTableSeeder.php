<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'name' => 'Test',
                'apellido_paterno' => 'test',
                'apellido_materno' => 'test',
                'usuario' => 'admin',
                'estatus' => '1',
                'id_rol' => '1',
                'email' => '1@1',
                'email_verified_at' => '2019-05-20 11:18:46',
                'password' => '$2y$10$964LYU0HFf1N.1B/eLcvTuhGwr9JddMI15U68c29dNkhV3WMt./Ii',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'rfc' => 'XXXX123456XX1'
            ),
        ));
    }
    
}
