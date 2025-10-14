<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'global_rating', 'film_genre', 'actors', 'director', 'photo'];

    public function Film_Users()
    {
        return $this->hasMany(FilmUser::class, 'film_id');
    }
}
