<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pokemon::truncate();

        $json = File::get("database/seeders/data/pokemons.json");
        $pokemons = json_decode($json);

        $SPRITES_TO_KEEP = [
            'front_default',
            'front_female',
            'front_shiny',
            'front_shiny_female',
            'back_default',
            'back_female',
            'back_shiny',
            'back_shiny_female',
        ];

        foreach ($pokemons as $key => $value) {
            Pokemon::create([
                "name" => $value->name,
                "sprites" => json_encode(array_reduce($SPRITES_TO_KEEP, function ($carry, $sprite) use ($value) {
                    if ($value->sprites->$sprite) {
                        $carry += [$sprite => $value->sprites->$sprite];
                    }
                    return $carry;
                }, [])),
                "types" => json_encode(array_map(function ($type) {
                    return ['type' => $type->type->name, 'slot' => $type->slot];
                }, $value->types)),
            ]);
        }
    }
}
