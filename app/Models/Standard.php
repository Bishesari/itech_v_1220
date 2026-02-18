<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Standard extends Model
{
    protected $fillable = [
        'field_id',
        'code',
        'name_fa',
        'name_en',
        'nazari_h',
        'amali_h',
        'karvarzi_h',
        'project_h',
        'required_h',
        'sum_h',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('number');
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
