<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'author_name',
        'publication-date',
        'image',
        'description',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function media(){
        return $this->hasMany(Media::class);
    }
}