<?php

namespace App\Http\Controllers\API;

use App\Models\WaAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WaAdminAPI extends Controller
{
    public function index()
    {
        $waAdmins = WaAdmin::all();

        $baseUrl = url('/'); 
        $waAdmins = $waAdmins->map(function ($waAdmin) use ($baseUrl) {
            $waAdmin->logo = $baseUrl . '/' . $waAdmin->logo; 
            return $waAdmin;
        });

        return response()->json([
            'data' => $waAdmins
        ], 200);
    }
}
