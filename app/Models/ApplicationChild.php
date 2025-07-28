<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationChild extends Model
{
    protected $fillable = ['application_id', 'name', 'registration_number', 'thana', 'photo_path'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
