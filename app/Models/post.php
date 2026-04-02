<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['user_id', 'title', 'content'])]

class post extends Model
{
    //relationships
    public function posts(): HasMany
    {
        return $this->hasMany(post::class); 
    }
}
