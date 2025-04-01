<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    protected $fillable = [
        'id',
        'date',
        'name',
    ];

    public $timestamps = false;


    public function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d.m.Y', strtotime($value)),
            set: fn ($value) => date('Y-m-d', strtotime($value)),
        );
    }
}
