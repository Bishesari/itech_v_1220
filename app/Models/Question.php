<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Question extends Model
{
    protected $fillable = [
        'standard_id',
        'chapter_id',
        'type',
        'designer_id',
        'question_text',
        'is_frequent_final',
        'is_active',
    ];

    protected $casts = [
        'is_frequent_final' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function designer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    // دامنه‌های استفاده از سوال (کشوری / استانی / شهری)
    public function scopes(): HasMany
    {
        return $this->hasMany(QuestionScope::class);
    }

    // یک سوال می‌تواند چند گزینه داشته باشد
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    // برای سوالات عملی، پاسخ عملی
    public function practicalAnswer(): HasOne
    {
        return $this->hasOne(PracticalAnswer::class);
    }

    // media مربوط به خود سوال
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }
}
