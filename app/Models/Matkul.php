<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    // use Sluggable;
    
    protected $table = 'matkul';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'nama', 'kode'
    ];

    public function program(){
        return $this->hasMany(Program::class, 'kategori_id');
    }
}
