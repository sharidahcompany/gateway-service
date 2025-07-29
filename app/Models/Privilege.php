<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Privilege extends Model
{



    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }
}
