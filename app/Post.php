<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    // add methods we can use
    use SoftDeletes;
    protected $dates = [];
    protected $fillable = ['title','description','content','image','user_id','published_at','category_id'];
    

    public function deleteImage () {
        Storage::delete($this->image);
    }

    public function category () {
        // reletionship 1 to many
        // return 1 post
        return $this-> belongsTo((Category::class));
    }
    // the post belongs to many tags
    public function tags() {
        
        return $this-> belongsToMany(Tag::class);
    }
    // if post has a tag
    public function hasTag($tagId) {
        return in_array($tagId,$this->tags->pluck('id')->toArray());
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function scopePublished ($query) {

        return $query->where('published_at','<=',now());
    }
    public function scopeSearched( $query) {
        // $query->where();
        $search = request()->query('search');
        if(!$search){
            // only published posts
            return $query->published();
        }
        // must be double quotes
        return $query->published()->where('title','LIKE',"%{$search}%");
    }

}
