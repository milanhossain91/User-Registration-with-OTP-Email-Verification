<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationPayment extends Model
{
    protected $fillable = ['application_id', 'payment_method', 'amount', 'date'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
