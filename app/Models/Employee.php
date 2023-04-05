<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable=[
        'employee_type',
        'employee_name',
        'employee_designation',
        'employee_contact_number',
        'employee_about',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
