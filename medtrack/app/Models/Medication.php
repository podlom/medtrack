<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medication extends Model
{
    protected $fillable = ['treatment_id', 'name', 'dosage', 'times_per_day', 'instructions'];

    public function treatment(): BelongsTo {
        return $this->belongsTo(Treatment::class);
    }
}
