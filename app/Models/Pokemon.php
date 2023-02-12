<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sprites',
    ];

    protected function sprites(): Attribute
    {
        return Attribute::make(
            get: fn($value) => array(
                "front_default" => $value,
            ),
        );
    }
}
