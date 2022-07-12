<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','abbreviation','deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];   
}
