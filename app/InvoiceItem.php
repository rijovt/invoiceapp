<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'name', 'price', 'qty', 'tax','tax_percent','value','total','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
