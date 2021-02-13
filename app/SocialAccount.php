<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    //added
    protected $fillable = [
        'user_id','provider_user_id','provider'
    ];

    //added
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
