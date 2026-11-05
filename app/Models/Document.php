<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_name',
        'document_type',
        'document_number',
        'issue_date',
        'expiry_date',
        'reminder_days',
        'file_path',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    // A document belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Check document expiry status
    public function getExpiryStatus(): string
    {
        if (!$this->expiry_date) {
            return 'Unknown';
        }

        $today = now()->startOfDay();
        $expiryDate = $this->expiry_date->copy()->startOfDay();

        if ($expiryDate->lt($today)) {
            return 'Expired';
        }

        if ($today->diffInDays($expiryDate) <= 30) {
            return 'Expiring Soon';
        }

        return 'Active';
    }
}
