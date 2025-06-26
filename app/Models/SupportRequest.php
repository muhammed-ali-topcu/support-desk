<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    /** @use HasFactory<\Database\Factories\SupportRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'subject',
        'message',
        'email',
    ];

}
