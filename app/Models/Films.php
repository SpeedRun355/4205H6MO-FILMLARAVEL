<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'global_rating', 'film_genre', 'actors', 'director'];

    public function Film_Users()
    {
        return $this->hasMany(Film_User::class);
    }
}
