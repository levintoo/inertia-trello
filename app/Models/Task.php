<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'column_id',
        'user_id',
        'name',
        'position',
        'due_date',
        'completed_at',
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    protected $appends = [
      'short_due_date',
    ];

    public function getShortDueDateAttribute(): ?string
    {
        return $this->due_date ? $this->due_date->format('d M Y') : null;
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    public function status(): string
    {
        if (! $this->due_date) {
            return $this->isCompleted() ? 'Completed' : 'Pending';
        }

        if (! $this->isCompleted() && now()->greaterThan($this->due_date)) {
            return 'Overdue';
        }

        if ($this->isCompleted() && $this->completed_at > $this->due_date) {
            return 'Completed Late';
        }

        return 'Completed On Time';
    }
}
