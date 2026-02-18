<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class QuestionOption extends Model
{
    protected $fillable = [
        'question_id',
        'option_text',
        'dir',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // هر گزینه می‌تواند media داشته باشد (عکس در متن گزینه)
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    // هر گزینه به یک سوال تعلق دارد
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
