<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'date',
        'time_start',
        'time_end',
        'description',
    ];

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function getPrettyStatus()
    {
        if ($this->is_present == 1) {
            return 'Time in only';
        } elseif ($this->is_present == 2) {
            return 'Present';
        }

        return 'Absent';
    }
}
