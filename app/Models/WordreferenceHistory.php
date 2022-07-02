<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordreferenceHistory extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'name'];
}
