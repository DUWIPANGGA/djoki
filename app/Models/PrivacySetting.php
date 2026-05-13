<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacySetting extends Model
{
    protected $fillable = [
        'user_id', 'profile_public', 'show_portfolio', 'allow_direct_messages',
        'encrypt_stored_files', 'anonymize_reviews',
    ];

    protected $casts = [
        'profile_public' => 'boolean',
        'show_portfolio' => 'boolean',
        'allow_direct_messages' => 'boolean',
        'encrypt_stored_files' => 'boolean',
        'anonymize_reviews' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}