<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pokemons' => array_map(fn($pokemon) => $pokemon['id'], $this->pokemons->toArray())];
    }

    public function pokemons()
    {
        return $this->hasMany(Pokemon::class);
    }
}
