<?php

namespace App\Http\Services;

use App\Http\Repositories\FeatureRepository;

class FeatureService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected FeatureRepository $feature_repository)
    {
        //
    }

    public function index()
    {
        return $this->feature_repository->index();
    }
}
