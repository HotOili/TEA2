<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ord extends Model
{
    protected $table = 'ord';
    public $timestamps = false;
    protected $fillable = ['id_order','status','id_tovar','colvo','reson','date'];

    public function tovar() { return $this->belongsTo(Tovar::class, 'id_tovar'); }
}