<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InstituteUser extends Pivot
{
    protected $table = 'institute_user';

    protected $fillable = [
        'institute_id',
        'branch_id',
        'user_id',
        'role_id',
        'is_last_selected',
        'is_active',
        'assigned_by_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

}
