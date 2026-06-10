<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;
    
    // Kita tidak pakai timestamp default (updated_at) karena log bersifat abadi (sekali tulis)
    // Tapi kita butuh created_at manual
    public $timestamps = false; 
    
    protected $guarded = ['id'];

    // --- TAMBAHKAN KODE INI ---
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Auto-fill created_at saat insert
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    // Relasi ke Aset
    public function asset()
    {
        return $this->belongsTo(Asset::class)->withTrashed(); // Tetap bisa baca aset meski sudah dihapus (soft delete)
    }

    // Relasi ke User (Actor/Pelaku perubahan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}