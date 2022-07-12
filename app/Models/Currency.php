<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','code','deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
