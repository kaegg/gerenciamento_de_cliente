<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "birth_date",
        "person_type",
        "cpf_cnpj",
        "email",
        "phone",
        "address_id",
        "profession_id",
        "active",
    ];

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
