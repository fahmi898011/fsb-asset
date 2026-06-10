<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    // Relasi ke Kategori (Inverse One-to-Many)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Ruangan (Inverse One-to-Many)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi ke User sebagai Penanggung Jawab (PIC)
    // Kita sebut fungsinya 'pic' agar lebih jelas konteksnya
    public function pic()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relasi ke Histori (One-to-Many)
    // Mengurutkan dari yang terbaru
    public function histories()
    {
        return $this->hasMany(AssetHistory::class)->orderBy('created_at', 'desc');
    }

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class)->orderBy('maintenance_date', 'desc');
    }
}