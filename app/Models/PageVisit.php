<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $fillable = [
        'page_key',
        'fingerprint',
        'visit_date',
        'user_id',
        'ip',
        'user_agent',
        'is_bot',
    ];
}
