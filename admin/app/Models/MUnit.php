<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MUnit extends Model
{
    protected $table = 'm_unit';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
