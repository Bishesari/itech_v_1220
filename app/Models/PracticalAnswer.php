<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PracticalAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'description',
    ];

    // هر جواب عملی می‌تواند چند media داشته باشد
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    // جواب عملی به یک سوال تعلق دارد
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
