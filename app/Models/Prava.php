<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prava extends Model
{
    protected $table = 'prava';
    public $timestamps = false;
    protected $fillable = ['role'];
}