<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

const SPRITES_TO_KEEP = [
    'front_default',
    'front_female',
    'front_shiny',
    'front_shiny_female',
    'back_default',
    'back_female',
    'back_shiny',
    'back_shiny_female',
];

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sprites',
        'types',
    ];

    public function toArray()
    {
        return ['id' => $this->id, 'name' => $this->name, 'sprites' => $this->sprites, 'types' => $this->types];
    }

    protected function frontDefault(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => array(
                "front_default" => json_decode($attributes['sprites'])->front_default,
            ),
        );
    }

    protected function sprites(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    protected function types(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    public static function sanitizeSprites($pokemon): array
    {
        return array_reduce(SPRITES_TO_KEEP, function ($carry, $sprite) use ($pokemon) {
            if ($pokemon->sprites->$sprite) {
                $carry += [$sprite => $pokemon->sprites->$sprite];
            }
            return $carry;
        }, []);
    }

    public static function sanitizeTypes($pokemon): array
    {
        return array_map(function ($type) {
            return ['type' => $type->type->name, 'slot' => $type->slot];
        }, $pokemon->types);
    }
}
