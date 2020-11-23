<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URLShort extends Model
{
    use HasFactory;

    protected $table = 'url';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'original_url',
        'custom_alias',
        'hash',
        'short_url',
        'expiration_date'
    ];
}
