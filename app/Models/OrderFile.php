<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id', 'uploaded_by', 'file_type', 'file_name', 'file_path', 'file_hash',
        'mime_type', 'size', 'access_token', 'token_expires_at', 'is_encrypted',
    ];

    // Scope: file hasil kerja dari provider
    public function scopeProviderFiles($query)
    {
        return $query->where('file_type', 'provider');
    }

    // Scope: file lampiran dari client
    public function scopeClientFiles($query)
    {
        return $query->where('file_type', 'client');
    }

    protected $casts = [
        'token_expires_at' => 'datetime',
        'is_encrypted' => 'boolean',
        'size' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Check if access token is still valid
    public function getIsTokenValidAttribute()
    {
        return $this->access_token && $this->token_expires_at && $this->token_expires_at->isFuture();
    }
}
