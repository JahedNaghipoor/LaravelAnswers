<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
     use Searchable;
    public function question()
    {
        return $this->hasOne('App\Question');
    }
}
