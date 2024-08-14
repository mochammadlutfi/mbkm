<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class KonversiDetail extends Model
{
    use HasFactory;
    // use Sluggable;
    
    protected $table = 'konversi_detail';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'nama', 'slug'
    ];

    public function konversi(){
        return $this->belongsTo(Konversi::class, 'konversi_id');
    }

    public function mitra_matkul(){
        return $this->belongsTo(Matkul::class, 'mitra_matkul_id');
    }

    public function matkul(){
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }
}
