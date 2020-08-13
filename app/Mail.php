<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $fillable = [
        'name', 
        'money',
        'email_id',
        'content',
        'phone',
        'time',
        'deal_id'
    ];
}
