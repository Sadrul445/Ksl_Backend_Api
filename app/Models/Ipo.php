<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipo extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_name',
        'cutt_off_date',
        'minimum_application_amount',
        'total_share',
        'eps',
        'nav',
        'rate',
        'type',
        'status'
    ];
}
