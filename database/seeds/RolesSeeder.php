<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array (


            1 =>
            array (
                'name' => 'SuperAdmin',
                'guard_name' =>'web'
            ),
            2 =>
            array (
                'name' => 'admin',
                'guard_name' =>'web'
            ),
            3 =>
            array (
                'name' => 'SinAsignar',
                'guard_name' =>'web'
            ),
        ));
    }
}
