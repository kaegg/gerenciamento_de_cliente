<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            [
                'name'          => 'Ana Maria',
                'birth_date'    => '1990-05-12',
                'person_type'   => 'F',
                'cpf_cnpj'      => '445.024.780-91',
                'email'         => 'ana.maria@example.com',
                'phone'         => '(44) 99999-1111',
                'address_id'    => rand(1, 4),
                'profession_id' => rand(1, 6),
                'active'        => true,
                'created_at'    => Carbon::now()->subDays(rand(0, 365)),
                'updated_at'    => Carbon::now(),
            ],[
                'name'          => 'Bruno Silva',
                'birth_date'    => '1982-11-20',
                'person_type'   => 'F',
                'cpf_cnpj'      => '245.282.970-60',
                'email'         => 'bruno.silva@example.com',
                'phone'         => '(44) 98888-2222',
                'address_id'    => rand(1, 4),
                'profession_id' => rand(1, 6),
                'active'        => false,
                'created_at'    => Carbon::now()->subDays(rand(0, 365)),
                'updated_at'    => Carbon::now(),
            ],[
                'name'          => 'Empresa Alfa LTDA',
                'birth_date'    => '2005-02-15',
                'person_type'   => 'J',
                'cpf_cnpj'      => '79.996.505/0001-08',
                'email'         => 'contato@empresaalfa.com',
                'phone'         => '(44) 3333-4444',
                'address_id'    => rand(1, 4),
                'profession_id' => rand(1, 6),
                'active'        => true,
                'created_at'    => Carbon::now()->subDays(rand(0, 365)),
                'updated_at'    => Carbon::now(),
            ],[
                'name'          => 'Carlos Pereira',
                'birth_date'    => '1975-07-30',
                'person_type'   => 'F',
                'cpf_cnpj'      => '153.642.950-36',
                'email'         => 'carlos.pereira@example.com',
                'phone'         => '(44) 97777-3333',
                'address_id'    => rand(1, 4),
                'profession_id' => rand(1, 6),
                'active'        => true,
                'created_at'    => Carbon::now()->subDays(rand(0, 365)),
                'updated_at'    => Carbon::now(),
            ],
        ];

        DB::table('clients')->insert($clients);
    }
}
