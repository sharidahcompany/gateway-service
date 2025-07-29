<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class);
    }

    public function privileges(): BelongsToMany
    {
        return $this->belongsToMany(Privilege::class);
    }
}
