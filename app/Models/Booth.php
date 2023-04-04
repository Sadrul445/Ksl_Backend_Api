<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    use HasFactory;

    protected $fillable = [
        'booth_name',
        'booth_address',
        'booth_helpline',
        'booth_mail',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
