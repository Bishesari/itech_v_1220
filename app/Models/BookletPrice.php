<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookletPrice extends Model
{
    protected $fillable = [
        'branch_standard_booklet_id',
        'price',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function booklet(): BelongsTo
    {
        return $this->belongsTo(BranchStandardBooklet::class, 'branch_standard_booklet_id');
    }
}
