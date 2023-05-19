<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'branches_name',
        'branches_address',
        'branches_helpline_1',
        'branches_helpline_2',
        'branches_email',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
