<?php

namespace App\Http\Controllers\v1;

use App\Enums\Currency;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Currency::all()], 200);
    }
}
