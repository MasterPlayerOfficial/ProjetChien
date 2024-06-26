<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'Alert';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idAnimal',
        'inProgress',
        'dateStart'
    ];

    public function animal()
    {
        return $this->belongsTo('App\Models\Animal', 'idAnimal');
    }
}
