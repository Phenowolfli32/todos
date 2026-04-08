<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'tags'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDueStatusAttribute()
    {
        if (!$this->due_date) return null;

        $today = now()->startOfDay();
        $dueDate = $this->due_date->startOfDay();

        if ($dueDate->lt($today)) return 'overdue';
        if ($dueDate->eq($today)) return 'due-today';
        return 'upcoming';
    }
}
