<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'assigned_to',
        'title',
        'priority',
        'status',
        'description',
        'attachment_path',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id')->latest();
    }

    public function canBeManagedBy(?User $user): bool
    {
        if ($this->status !== 'open') {
            return $user?->is_admin ?? false;
        }

        return (bool) $user && ($user->is_admin || $this->user_id === $user->id);
    }
}
