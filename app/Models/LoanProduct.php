<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_type',
        'description',
        'min_amount',
        'max_amount',
        'min_tenor',
        'max_tenor',
        'late_fee_percentage',
        'eligibility_criteria',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'eligibility_criteria' => 'array',
            'created_at' => 'datetime',
        ];
    }

    // 🔗 Relationships
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function loanApplications() { return $this->hasMany(LoanApplication::class, 'product_id'); }
    public function loans() { return $this->hasMany(Loan::class, 'product_id'); }
}
