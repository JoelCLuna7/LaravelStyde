<?php

use App\User;
use App\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//       $profession = DB::select('SELECT id FROM professions WHERE  title = ?',['Desarrollador Back-end']);

      $professionId = Profession::where('title','Desarrollador Back-end')->value('id');

        User::create([

            'name'=> 'Joel Celaya',
            'email' => 'joelcluna@gmial.com',
            'password' => bcrypt('joelcluna'),
            'profession_id' => $professionId,
        ]);
    }
}
