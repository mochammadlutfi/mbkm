<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Konversi extends Model
{
    use HasFactory;
    // use Sluggable;
    
    protected $table = 'konversi';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'nama', 'slug'
    ];

    public function detail(){
        return $this->hasMany(KonversiDetail::class, 'konversi_id');
    }

    public function daftar(){
        return $this->belongsTo(UserProgram::class, 'user_program_id');
    }

    public function matkul(){
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }
}
