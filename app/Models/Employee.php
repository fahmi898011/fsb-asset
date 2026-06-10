<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    // Relasi: Pegawai bisa memegang banyak aset
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}