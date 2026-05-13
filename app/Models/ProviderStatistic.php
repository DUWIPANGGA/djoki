<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderStatistic extends Model
{
    protected $fillable = [
        'provider_id', 'total_orders_completed', 'total_orders_cancelled',
        'completion_rate', 'avg_rating', 'avg_response_time_seconds',
        'total_revisions', 'last_order_at',
    ];

    protected $casts = [
        'completion_rate' => 'float',
        'avg_rating' => 'float',
        'avg_response_time_seconds' => 'float',
        'total_orders_completed' => 'integer',
        'total_orders_cancelled' => 'integer',
        'total_revisions' => 'integer',
        'last_order_at' => 'datetime',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    // Helper to update completion rate
    public function updateCompletionRate()
    {
        $total = $this->total_orders_completed + $this->total_orders_cancelled;
        if ($total === 0) {
            $this->completion_rate = 100;
        } else {
            $this->completion_rate = round(($this->total_orders_completed / $total) * 100, 2);
        }
        $this->saveQuietly();
    }
}