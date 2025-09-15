<?php

// app/Model/Token.php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'token',
        'expires_at'
    ];
}