<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'Animal';
    protected $primaryKey = 'idAnimal';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'birth',
        'race',
        'color',
        'lost'
    ];
}
