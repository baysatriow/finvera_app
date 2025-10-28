<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $primaryKey = 'loan_id';

    protected $fillable = [
        'loan_number',
        'user_id',
        'product_id',
        'amount',
        'tenor',
        'purpose',
        'status',
        'application_date',
        'approval_date',
        'disbursement_date',
        'due_date',
        'completed_date',
        'approved_by',
        'credit_score_at_application',
    ];

    protected function casts(): array
    {
        return [
            'application_date' => 'datetime',
            'approval_date' => 'datetime',
            'disbursement_date' => 'datetime',
            'due_date' => 'date',
            'completed_date' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function product() { return $this->belongsTo(LoanProduct::class, 'product_id'); }
    public function installments() { return $this->hasMany(Installment::class, 'loan_id'); }
    public function payments() { return $this->hasMany(Payment::class, 'loan_id'); }
}
