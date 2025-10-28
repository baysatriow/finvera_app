<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'phone_number',
        'date_of_birth',
        'address',
        'occupation',
        'monthly_income',
        'credit_score',
        'role',
        'status',
        'kyc_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔗 Relationships
    public function kycVerifications() { return $this->hasMany(KycVerification::class, 'user_id'); }
    public function loanApplications() { return $this->hasMany(LoanApplication::class, 'user_id'); }
    public function loans() { return $this->hasMany(Loan::class, 'user_id'); }
    public function notifications() { return $this->hasMany(Notification::class, 'user_id'); }
    public function payments() { return $this->hasMany(Payment::class, 'verified_by'); }
    public function createdTerms() { return $this->hasMany(TermsAndConditions::class, 'created_by'); }
    public function userTermsAcceptances() { return $this->hasMany(UserTermsAndAcceptance::class, 'user_id'); }
}
