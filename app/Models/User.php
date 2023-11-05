<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\News;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const ADMIN_LEVEL = 30;
    const EMPRESA_LEVEL = 20;
    const DEFAULT_LEVEL = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        //login com o google
        'google_id',
        'terms_privacy',
    ];

    public function isAdministrator(){
        return $this->level == User::ADMIN_LEVEL;
    }

    public function isEmpresa(){
        return $this->level == User::EMPRESA_LEVEL;
    }
    
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        //login com o google
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //login com o google
    protected $appends = [
        'profile_photo_url',
    ];

    public function news(){
        return $this->hasMany(News::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }
    
}
