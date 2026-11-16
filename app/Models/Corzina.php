<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corzina extends Model
{
    protected $table = 'corzina';
    public $timestamps = false;
    protected $fillable = ['id_user','id_tovar','colvo'];

    public function tovar() { return $this->belongsTo(Tovar::class, 'id_tovar'); }
    public function user()  { return $this->belongsTo(User::class, 'id_user'); }
}