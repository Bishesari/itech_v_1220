<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /*protected $fillable = [
        'amount',
        'res_num',
        'ref_num',
        'status',
    ];*/
    protected $fillable = [
        'order_id',
        'user_id',
        'gateway',
        'amount',
        'status',
        'authority',
        'ref_id',
        'paid_at',
        'payload',
    ];

    protected $casts = [
        'amount' => 'integer',
        'paid_at' => 'datetime',
        'payload' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
