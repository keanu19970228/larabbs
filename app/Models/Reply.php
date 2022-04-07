<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function Topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
