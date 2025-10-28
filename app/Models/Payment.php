<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_method',
        'payment_date',
        'reference_number',
        'status',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function loan() { return $this->belongsTo(Loan::class, 'loan_id'); }
    public function verifier() { return $this->belongsTo(User::class, 'verified_by'); }
}
