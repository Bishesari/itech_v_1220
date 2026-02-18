<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institute extends Model
{
    protected $fillable = [
        'short_name',
        'full_name',
        'abbr',
        'remain_credit',
        'logo_url',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'institute_user', 'institute_id', 'user_id')
            ->using(InstituteUser::class)
            ->withPivot(['branch_id', 'role_id', 'is_active'])
            ->wherePivotNull('branch_id')
            ->withTimestamps();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'institute_user', 'institute_id', 'role_id')
            ->using(InstituteUser::class)
            ->withPivot(['user_id', 'branch_id', 'is_active'])
            ->withTimestamps();
    }
}
