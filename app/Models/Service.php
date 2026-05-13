<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'min_price', 'max_price', 'estimated_time', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_price' => 'integer',
        'max_price' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function providerServices()
    {
        return $this->hasMany(ProviderService::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}