<?php
use App\Models\Menu;
use Illuminate\Database\Seeder;
class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
    {
        $m1 = factory(Menu::class)->create([
            'menu' => 'Opción 1',
            'slug' => 'opcion1',
            'padre' => 0,
            'orden' => 0,
            'ruta' =>"/home",

        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 2',
            'slug' => 'opcion2',
            'padre' => 0,
            'orden' => 1,
            'ruta' =>"/home",
        ]);
        $m3 = factory(Menu::class)->create([
            'menu' => 'Opción 3',
            'slug' => 'opcion3',
            'padre' => 0,
            'orden' => 2,
            'ruta' =>"/home",
        ]);
        $m4 = factory(Menu::class)->create([
            'menu' => 'Opción 4',
            'slug' => 'opcion4',
            'padre' => 0,
            'orden' => 3,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 1.1',
            'slug' => 'opcion-1.1',
            'padre' => $m1->id,
            'orden' => 0,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 1.2',
            'slug' => 'opcion-1.2',
            'padre' => $m1->id,
            'orden' => 1,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 3.1',
            'slug' => 'opcion-3.1',
            'padre' => $m3->id,
            'orden' => 0,
            'ruta' =>"/home",
        ]);
        $m32 = factory(Menu::class)->create([
            'menu' => 'Opción 3.2',
            'slug' => 'opcion-3.2',
            'padre' => $m3->id,
            'orden' => 1,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 4.1',
            'slug' => 'opcion-4.1',
            'padre' => $m4->id,
            'orden' => 0,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 3.2.1',
            'slug' => 'opcion-3.2.1',
            'padre' => $m32->id,
            'orden' => 0,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 3.2.2',
            'slug' => 'opcion-3.2.2',
            'padre' => $m32->id,
            'orden' => 1,
            'ruta' =>"/home",
        ]);
        factory(Menu::class)->create([
            'menu' => 'Opción 3.2.3',
            'slug' => 'opcion-3.2.3',
            'padre' => $m32->id,
            'orden' => 2,
            'ruta' =>"/home",
        ]);
    }
}
