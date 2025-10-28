<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTermsAndAcceptance extends Model
{
    use HasFactory;

    protected $primaryKey = 'acceptance_id';

    protected $fillable = [
        'user_id',
        'term_id',
        'ip_address',
        'acceptance_hash',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function term() { return $this->belongsTo(TermsAndConditions::class, 'term_id'); }
}
