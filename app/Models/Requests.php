<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'text',
        'file_path',
    ];

    // Определение отношения "многие к одному" с моделью User (один пользователь может иметь много заявок)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Определение отношения "многие к одному" с моделью Topic (одна тема может быть связана с множеством заявок)
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
