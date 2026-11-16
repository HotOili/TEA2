<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tovar extends Model
{
    protected $table = 'tovar';
    public $timestamps = false;
    protected $fillable = [
        'img','name','price','discription','category',
        'country','year','model','nalichie','is_published','created_at',
    ];
    protected $casts = ['is_published' => 'boolean'];

    public function categoryRel() { return $this->belongsTo(Category::class, 'category'); }

    public function scopeAvailable($q) {
        return $q->where('is_published', 1)->where('nalichie', '>', 0);
    }
}