<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    // Relasi: Satu kategori punya banyak aset
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
