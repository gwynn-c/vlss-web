<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'topic',
        'budget',
        'message',
        'ip_address',
    ];
}
