<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgram extends Model
{
    use HasFactory;
    
    protected $table = 'user_program';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'nama',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function program(){
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function konversi(){
        return $this->hasMany(Konversi::class, 'user_program_id');
    }
}
