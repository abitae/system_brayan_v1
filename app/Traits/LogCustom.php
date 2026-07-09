<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogCustom
{
    function infoLog($campo)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/success.log'),
        ])->info($campo . ' - ' . Auth::user()->email);
        return true;
    }
    function errorLog($campo, $e)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/error.log'),
        ])->error($campo . ' - ' . Auth::user()->email . ' Error: ' . $e->getMessage());
        return true;
    }
}
