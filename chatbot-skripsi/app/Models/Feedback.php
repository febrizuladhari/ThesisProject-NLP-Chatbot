<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'rating',
        'comment'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
