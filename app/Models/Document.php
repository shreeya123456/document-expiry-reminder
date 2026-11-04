<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'document_name',
        'document_type',
        'document_number',
        'issue_date',
        'expiry_date',
        'reminder_days',
        'file_path',
    ];
}