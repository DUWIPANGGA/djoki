<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMilestone extends Model
{
    protected $fillable = [
        'order_id', 'name', 'description', 'position', 'status', 'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'position' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
