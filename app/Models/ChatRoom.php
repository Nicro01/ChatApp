<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function messages()
    {
        return $this->hasMany('App\Models\ChatMessage');
    }
}
