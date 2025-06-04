<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Address;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Client::with(['profession', 'address']);

        if ($request->filled('created_at_begins')) {
            $query->whereDate('created_at', '>=', $request->created_at_begins);
        }

        if ($request->filled('created_at_end')) {
            $query->whereDate('created_at', '<=', $request->created_at_end);
        }

        if ($request->filled('active')) {
            $query->where('active', $request->active);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $clients = $query->get();

        return response()->json([
            'status'  => true,
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        $profession = Profession::where('profession_name', $validated['profession_name'])->first();

        if (!$profession) {
            return response()->json([
                'status'  => false,
                'message' => 'Profissão inválida.',
            ], 422);
        }

        $address = Address::firstOrCreate([
            'address'      => $validated['address'],
            'number'       => $validated['number'],
            'neighborhood' => $validated['neighborhood'],
            'complement'   => $validated['complement'],
            'city'         => $validated['city'],
            'state'        => $validated['state'],
        ]);

        $client = Client::create([
            'name'          => $validated['name'],
            'birth_date'    => $validated['birth_date'],
            'person_type'   => $validated['person_type'],
            'cpf_cnpj'      => $validated['cpf_cnpj'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'address_id'    => $address->id,
            'profession_id' => $profession->id,
            'active'        => $validated['active']
        ]);

        $client->load(['address', 'profession']);

        return response()->json([
            'status'  => true,
            'message' => 'Cliente cadastrado com sucesso!',
            'client'  => $client
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        $profession = Profession::where('profession_name', $validated['profession_name'])->first();

        if (!$profession) {
            return response()->json([
                'status'  => false,
                'message' => 'Profissão inválida.',
            ], 422);
        }

        $address = Address::firstOrCreate([
            'address'      => $validated['address'],
            'number'       => $validated['number'],
            'neighborhood' => $validated['neighborhood'],
            'complement'   => $validated['complement'],
            'city'         => $validated['city'],
            'state'        => $validated['state'],
        ]);

        $client->update([
            'name'          => $validated['name'],
            'birth_date'    => $validated['birth_date'],
            'person_type'   => $validated['person_type'],
            'cpf_cnpj'      => $validated['cpf_cnpj'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'address_id'    => $address->id,
            'profession_id' => $profession->id,
            'active'        => $validated['active'],
        ]);

        $client->load(['address', 'profession']);

        return response()->json([
            'status'  => true,
            'message' => 'Cliente atualizado com sucesso!',
            'client'  => $client
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
