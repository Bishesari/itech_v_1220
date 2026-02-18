<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function questionScopes(): HasMany
    {
        return $this->hasMany(QuestionScope::class);
    }
}
