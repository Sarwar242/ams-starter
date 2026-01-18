<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessPartner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'business_partners';

    protected $fillable = [
        'name',
        'code',
        'is_subcontractor',
        'contact_person',
        'phone',
        'email',
        'created',    // created by user ID
        'modified',   // modified by user ID
        'deleted',    // deleted by user ID
    ];

    protected $casts = [
        'is_subcontractor' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'modified');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted');
    }
}