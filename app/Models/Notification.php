<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'notification_type',
        'category',
        'is_read',
        'scheduled_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'scheduled_at' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
