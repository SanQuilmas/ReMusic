<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partitura extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'image_path',
        'musicxml_path',
        'midi_path'
    ];
}
