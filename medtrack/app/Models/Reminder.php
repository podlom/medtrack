<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    protected $fillable = ['treatment_id', 'remind_at', 'method', 'is_active'];

    public function treatment(): BelongsTo {
        return $this->belongsTo(Treatment::class);
    }
}
