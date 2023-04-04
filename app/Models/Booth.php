<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    use HasFactory;

    protected $fillable = [
        'booths_name',
        'booths_address',
        'booths_helpline',
        'booths_email',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
