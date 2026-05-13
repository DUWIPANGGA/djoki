<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number', 'client_id', 'provider_id', 'service_id', 'provider_service_id',
        'payment_type', 'total_price', 'dp_amount', 'payment_status', 'payment_method',
        'payment_proof_path', 'provider_payment_status', 'provider_payment_proof_path', 'status', 'start_date', 'deadline', 'estimated_completion',
        'revision_limit', 'revision_count', 'is_confidential', 'private_notes',
        'milestone_summary',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'deadline' => 'datetime',
        'is_confidential' => 'boolean',
        'milestone_summary' => 'array',
        'total_price' => 'integer',
        'dp_amount' => 'integer',
        'revision_limit' => 'integer',
        'revision_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-'.strtoupper(uniqid());
            }
        });

        static::created(function ($order) {
            $order->trackingLogs()->create([
                'new_status' => 'pending',
                'remarks' => 'Pesanan berhasil dibuat oleh klien.',
                'changed_by' => auth()->id() ?? $order->client_id,
            ]);
        });

        static::updated(function ($order) {
            if ($order->wasChanged('status')) {
                $order->trackingLogs()->create([
                    'old_status' => $order->getOriginal('status'),
                    'new_status' => $order->status,
                    'remarks' => 'Status pesanan diubah menjadi ' . strtoupper($order->status),
                    'changed_by' => auth()->id(),
                ]);
            }

            if ($order->wasChanged('provider_id') && $order->provider_id) {
                $order->trackingLogs()->create([
                    'new_status' => $order->status,
                    'remarks' => 'Pesanan telah diberikan kepada provider: ' . $order->provider->name,
                    'changed_by' => auth()->id(),
                ]);
            }

            if ($order->wasChanged('payment_status') && $order->payment_status === 'paid') {
                $order->trackingLogs()->create([
                    'new_status' => $order->status,
                    'remarks' => 'Pembayaran telah dikonfirmasi oleh Admin.',
                    'changed_by' => auth()->id(),
                ]);
            }
        });
    }

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function providerService()
    {
        return $this->belongsTo(ProviderService::class);
    }

    public function milestones()
    {
        return $this->hasMany(OrderMilestone::class);
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function trackingLogs()
    {
        return $this->hasMany(OrderTrackingLog::class);
    }

    // Accessors
    public function getProgressAttribute()
    {
        $summary = $this->milestone_summary;
        if (is_array($summary) && isset($summary['progress'])) {
            return (int) $summary['progress'];
        }

        $total = $this->milestones->count();
        if ($total === 0) {
            return 0;
        }
        $completed = $this->milestones->where('status', 'completed')->count();

        return round(($completed / $total) * 100);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp '.number_format($this->total_price, 0, ',', '.');
    }
}
