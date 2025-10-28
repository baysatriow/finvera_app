<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $primaryKey = 'installment_id';

    protected $fillable = [
        'loan_id',
        'installment_number',
        'due_date',
        'amount',
        'status',
        'paid_amount',
        'paid_date',
        'late_fee',
        'days_late',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_date' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function loan() { return $this->belongsTo(Loan::class, 'loan_id'); }
}
