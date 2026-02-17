<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    protected $fillable = ['ip', 'n_code', 'contact_value', 'otp', 'expires_at',
        'otp_hash'
    ];

    protected function casts(): array
    {
        return [
            'otp_hash' => 'hashed',
        ];
    }
}
