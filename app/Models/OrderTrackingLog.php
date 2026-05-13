<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrackingLog extends Model
{
    protected $fillable = [
        'order_id', 'old_status', 'new_status', 'remarks', 'changed_by',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
