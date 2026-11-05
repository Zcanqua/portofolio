<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'title',
        'issuer',
        'year',
        'description',
        'url',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }
}
