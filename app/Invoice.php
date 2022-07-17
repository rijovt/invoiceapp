<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no', 'user_id','total_amount','discount','final_amount'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
