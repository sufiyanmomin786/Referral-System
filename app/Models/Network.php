<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'referral_code',
        'parant_user_id',
    ];
    public function user()
    {
        return $this->hasone(User::class,'id','user_id');
    }
}
