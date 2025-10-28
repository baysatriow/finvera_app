<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsAndConditions extends Model
{
    use HasFactory;

    protected $primaryKey = 'term_id';

    protected $fillable = [
        'title',
        'content',
        'version',
        'term_type',
        'regulatory_references',
        'dps_approval_number',
        'required_for',
        'acceptance_required',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'regulatory_references' => 'array',
            'acceptance_required' => 'boolean',
        ];
    }

    // 🔗 Relationships
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function userAcceptances() { return $this->hasMany(UserTermsAndAcceptance::class, 'term_id'); }
}
