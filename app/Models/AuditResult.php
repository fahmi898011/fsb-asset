<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditResult extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false; // Kita pakai scanned_at manual

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}