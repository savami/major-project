<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoJob extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'pexels_response' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
