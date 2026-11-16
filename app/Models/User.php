<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    public $timestamps = false;

    protected $fillable = [
        'name','surname','patronymic','login','email','password','img','prava',
    ];
    protected $hidden = ['password', 'remember_token'];

    public function getFullNameAttribute(): string {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }

    public function isAdmin(): bool  { return (int)$this->prava === 3; }
    public function isClient(): bool { return (int)$this->prava === 1; }

    public function cart()   { return $this->hasMany(Corzina::class, 'id_user'); }
    public function orders() { return $this->hasManyThrough(
        Grypirovca::class, Grypirovca::class, 'id_user', 'id_order', 'id', 'id_order'
    ); }
}
