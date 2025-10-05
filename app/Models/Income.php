<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    /* use HasFactory; */  // Uncomment this if you need factory support
    protected $fillable = ['user', 'income_source', 'total', 'date'];
}
