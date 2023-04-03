<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'newspaper_name',
        'newspaper_url',
        'newspaper_title',
        'newspaper_description',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
