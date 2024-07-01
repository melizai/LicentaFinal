<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'deadline',
        'zip_description',
        'users_notified',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'content' => 'array',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
