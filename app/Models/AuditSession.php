<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSession extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function auditor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function results()
    {
        return $this->hasMany(AuditResult::class);
    }
}