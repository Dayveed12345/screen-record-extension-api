<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;
    public function transcript():HasMany
    {
        return $this->hasMany(transcript::class);
    }
    public function segment():HasMany
    {
        return $this->hasMany(segment::class);
    }
    public function word():HasMany
    {
        return $this->has(word::class);
    }
}
