<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['name', 'district', 'thana', 'village', 'mobile', 'photo_path','email'];

    public function children()
    {
        return $this->hasMany(ApplicationChild::class);
    }

    public function payments()
    {
        return $this->hasMany(ApplicationPayment::class);
    }
}
