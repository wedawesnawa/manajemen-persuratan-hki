<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'body', 'file', 'status'];
}
