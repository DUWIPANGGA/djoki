<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
    protected $fillable = [
        'provider_id', 'service_id', 'price_start', 'is_negotiable', 'is_available',
    ];

    protected $casts = [
        'is_negotiable' => 'boolean',
        'is_available' => 'boolean',
        'price_start' => 'integer',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
