<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //fillable properties
    protected $fillable = ['user_id', 'thumbanil', 'title', 'slug', 'sub_title', 'details', 'post_type', 'is_published'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_posts');
    }
}
