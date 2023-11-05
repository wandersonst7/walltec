<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\User;

class News extends Model
{
use HasFactory, SoftDeletes;
protected $fillable = [
    "title",
    "introduction",
    "category",
    "image",
    "news_text",
    "slug",
    "user_id"
];



public function setTitleAttribute($title){
    $this->attributes["title"] = $title;
    if ($this->slug != "")
            return;
    $news = News::withTrashed()
                    ->orderByDesc("id")
                    ->first();
    $id = "";
    if ($news){
        $id = "_".($news->id + 1);
    }

    $this->attributes["slug"] = Str::slug($title).$id;
}


public function user(){
    return $this->belongsTo(User::class);
}

public function comments(){
    return $this->hasMany(Comment::class);
}

public function manycategories(){
    return $this->belongsToMany(Category::class, "category_news");
}

}
