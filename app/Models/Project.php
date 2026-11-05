<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'category',
        'description',
        'image',
        'image_alt',
        'url',
        'technologies',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
        ];
    }
}
