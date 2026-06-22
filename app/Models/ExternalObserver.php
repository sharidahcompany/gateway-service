<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Model;

class ExternalObserver extends Model
{
    protected $table = 'external_observers';

    protected $fillable = [
        'from',
        'from_name',
        'to',
        'to_name',
        'status',
        'applied_by',
        'applied_by_uuid',
        'action_by',
    ];

    protected $casts = [
        'status' => ApprovalStatus::class,
        'from_name' => 'array',
        'to_name' => 'array',
    ];
}
