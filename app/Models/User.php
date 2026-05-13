<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'avatar', 'bio',
        'social_id', 'social_type',
        'provider_verified_at', 'verification_status', 'rating_avg',
        'total_orders', 'total_earnings', 'response_time_avg', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'provider_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'total_orders' => 'integer',
        'total_earnings' => 'integer',
        'rating_avg' => 'float',
    ];

    // Relations
    public function providerServices()
    {
        return $this->hasMany(ProviderService::class, 'provider_id');
    }

    public function ordersAsClient()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function ordersAsProvider()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'provider_id');
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class, 'uploaded_by');
    }

    public function statistics()
    {
        return $this->hasOne(ProviderStatistic::class, 'provider_id');
    }

    public function verificationDocuments()
    {
        return $this->hasMany(VerificationDocument::class);
    }

    public function privacySetting()
    {
        return $this->hasOne(PrivacySetting::class);
    }

    public function trackingLogs()
    {
        return $this->hasMany(OrderTrackingLog::class, 'changed_by');
    }

    // Accessors
    public function getIsVerifiedProviderAttribute()
    {
        return $this->role === 'provider' && ! is_null($this->provider_verified_at);
    }

    // Scopes
    public function scopeVerifiedProviders($query)
    {
        return $query->where('role', 'provider')
            ->whereNotNull('provider_verified_at');
    }
}
