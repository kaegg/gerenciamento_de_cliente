<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $professions = [
            [
                'profession_name' => 'Administração',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],[
                'profession_name' => 'Consultor',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],[
                'profession_name' => 'Contabilidade',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],[
                'profession_name' => 'Engenheiro de Software',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],[
                'profession_name' => 'Logística',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],[
                'profession_name' => 'Recursos Humanos',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],
        ];

        DB::table('professions')->insert($professions);

    }
}
