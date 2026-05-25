<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueMessage extends Model
{
    protected $fillable = [
        'type',
        'status',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
    ];
}
