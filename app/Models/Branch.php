<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    protected $fillable = [
        'institute_id',
        'short_name',
        'code',
        'is_main',
        'province_id',
        'city_id',
        'address',
        'postal_code',
        'phone',
        'mobile',
        'is_active',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
    ];


    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function users(): BelongsToMany
    {

        return $this->belongsToMany(User::class, 'institute_user', 'branch_id', 'user_id')
            ->using(InstituteUser::class)
            ->withPivot(['institute_id', 'role_id', 'is_active'])
            ->wherePivotNotNull('branch_id')
            ->withTimestamps();
    }
}
