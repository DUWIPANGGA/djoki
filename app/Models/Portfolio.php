<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'provider_id', 'order_id', 'title', 'description', 'media_files',
        'external_link', 'is_public',
    ];

    protected $casts = [
        'media_files' => 'array',
        'is_public' => 'boolean',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
