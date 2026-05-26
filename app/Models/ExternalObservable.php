<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Model;

class ExternalObservable extends Model
{
    protected $table = 'external_observables';

    protected $fillable = [
        'from',
        'from_name',
        'to',
        'to_name',
        'status',
    ];

    protected $casts = [
        'status' => ApprovalStatus::class,
        'from_name' => 'array',
        'to_name' => 'array',
    ];
}
