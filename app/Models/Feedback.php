<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'message', 'sender'];

    public function user()
{
    return $this->belongsTo(User::class, 'username', 'username');
}

    public function replies()
{
    return $this->hasMany(FeedbackReply::class);
}



}
