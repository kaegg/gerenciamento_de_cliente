<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = [
            [
                'address'      => 'Av. Paraná',
                'number'       => 442,
                'neighborhood' => 'Zona 07',
                'complement'   => '',
                'city'         => 'Maringá',
                'state'        => 'PR',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],[
                'address'      => 'Rua das Flores',
                'number'       => 123,
                'neighborhood' => 'Jardim América',
                'complement'   => 'Apto 101',
                'city'         => 'São Paulo',
                'state'        => 'SP',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],[
                'address'      => 'Avenida Brasil',
                'number'       => 456,
                'neighborhood' => 'Centro',
                'complement'   => null,
                'city'         => 'Rio de Janeiro',
                'state'        => 'RJ',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],[
                'address'      => 'Rua das Acácias',
                'number'       => 789,
                'neighborhood' => 'Vila Nova',
                'complement'   => 'Casa',
                'city'         => 'Belo Horizonte',
                'state'        => 'MG',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]
        ];

        DB::table('addresses')->insert($addresses);
    }
}
