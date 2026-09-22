<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class SystemClean extends Controller
{
    public function index()
    {
        // Clear all caches (cache, config, route, view, compiled)
        Artisan::call('optimize:clear');

        // Create storage link
        Artisan::call('storage:link');
 
        return response()->json([
            'status' => 'success',
            'message' => 'System cleaned.'
        ]);
    }
} 