<?php

use Illuminate\Database\Seeder;

class RoleHasPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('role_has_permissions')->delete();

        \DB::table('role_has_permissions')->insert(array (


            1 =>
            array (
                'permission_id' => '1',
                'role_id' =>'1'
            ),
            2 =>
            array (
                'permission_id' => '2',
                'role_id' =>'2'
            )
        ));
    }
}
