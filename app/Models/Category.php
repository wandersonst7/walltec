<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{

use HasFactory, SoftDeletes;
protected $fillable = [
    "name_category",
    "user_id"
];

public function user(){
    return $this->belongsTo(User::class);
}

public function manynews(){
    return $this->belongsToMany(News::class, "category_news");
}

}
