<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    //
    protected $fillable = ['title', 'description', 'image','duration','batch_size','certificate'];
}
