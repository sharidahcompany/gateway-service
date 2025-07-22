<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase, HasMedia
{
    use HasDatabase, HasDomains, InteractsWithMedia;

    protected $fillable = [
        'id',
        'name',
        'commercial_number',
        'tax_number'
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'commercial_number',
            'tax_number'
        ];
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('logo');
    }

}
