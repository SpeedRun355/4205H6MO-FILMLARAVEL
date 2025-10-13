<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmUser extends Model
{
    use HasFactory;

    protected $table = 'film_user';  
    protected $fillable = ['review', 'comment', 'user_id', 'film_id', 'erase'];

    public function films()
    {
        return $this->belongsTo(Films::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
