<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name','deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }
}
