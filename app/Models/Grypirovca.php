<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grypirovca extends Model
{
    protected $table = 'grypirovca';
    public $timestamps = false;
    protected $fillable = ['id_order','id_user','id_tovar','colvo'];
}