<?php

namespace App\Http\Controllers\v1\Central;

use App\Enums\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Country::all()], 200);
    }
}
