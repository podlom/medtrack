<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'start_date', 'end_date'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function medications(): HasMany {
        return $this->hasMany(Medication::class);
    }

    public function reminders(): HasMany {
        return $this->hasMany(Reminder::class);
    }
}
