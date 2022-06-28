<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // permit mass assignment of name
    protected $fillable = ['name'];

    public function  posts () {
                // reletionship 1 to many
                // how many does it have 
                // return num of reletionships
        return $this->hasMany(Post::class);
    }
}
