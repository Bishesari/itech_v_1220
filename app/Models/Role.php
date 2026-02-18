<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'scope',
        'color',
        'is_active',
    ];
    protected $casts = [
        'scope' => 'string',
        'is_active' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'institute_user', 'role_id', 'user_id')
            ->using(InstituteUser::class)
            ->withPivot(['institute_id', 'branch_id', 'is_active'])
            ->withTimestamps();
    }

    public function institutes(): BelongsToMany
    {
        return $this->belongsToMany(Institute::class, 'institute_user', 'role_id', 'institute_id')
            ->using(InstituteUser::class)
            ->withPivot(['user_id', 'branch_id', 'is_active'])
            ->withTimestamps();
    }
}
