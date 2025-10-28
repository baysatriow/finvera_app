<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'purpose',
        'amount',
        'tenor',
        'proofing_type_loan',
        'kyc_verification_id',
        'credit_score_at_application',
        'status',
        'application_date',
        'max_amount',
    ];

    protected function casts(): array
    {
        return [
            'application_date' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function product() { return $this->belongsTo(LoanProduct::class, 'product_id'); }
    public function kycVerification() { return $this->belongsTo(KycVerification::class, 'kyc_verification_id'); }
}
