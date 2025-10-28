<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    use HasFactory;

    protected $primaryKey = 'verification_id';

    protected $fillable = [
        'user_id',
        'id_card_number',
        'id_card_image',
        'selfie_with_id_image',
        'status',
        'verified_by',
        'verified_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function verifier() { return $this->belongsTo(User::class, 'verified_by'); }
}
