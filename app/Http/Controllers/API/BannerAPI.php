<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerAPI extends Controller
{
    public function index()
    {
        try {
            $banner = Banner::all();

            $baseUrl = url('/');
            $banner = $banner->map(function ($item) use ($baseUrl) {
                if ($item->images) {
                    $item->images = $baseUrl . '/storage' . '/' . $item->images;
                }
                return $item;
            });

            return response()->json([
                'data' => $banner
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
