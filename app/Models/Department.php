<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'created',
        'modified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the users belonging to this department.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the user who created this department.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created')->withoutGlobalScopes();
    }

    /**
     * Get the user who last modified this department.
     */
    public function modifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified')->withoutGlobalScopes();
    }

    /**
     * Get the user who deleted this department.
     */
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted')->withoutGlobalScopes();
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set the created and modified user IDs
        static::creating(function ($department) {
            if (auth()->check()) {
                $department->created = auth()->id();
                $department->modified = auth()->id();
            }
        });

        static::updating(function ($department) {
            if (auth()->check()) {
                $department->modified = auth()->id();
            }
        });

        // Set the deleted user ID when soft deleting
        static::deleting(function ($department) {
            if (auth()->check() && !$department->isForceDeleting()) {
                $department->deleted = auth()->id();
                $department->saveQuietly();
            }
        });
    }
}
