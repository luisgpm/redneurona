<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sensores extends Model
{
    use HasFactory;
    protected $fillable = ['q1', 'q2', 'q3'];



}
