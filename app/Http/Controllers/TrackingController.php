<?php

namespace App\Http\Controllers;

use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackingController extends Controller
{
    protected $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * E-posta tracking pixel
     */
    public function track(string $key, Request $request)
    {
        // Tracking event'i kaydet
        $this->trackingService->trackEvent($key, $request);

        // 1x1 transparent PNG döndür
        $pixel = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');

        return response($pixel, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=31536000', // 1 yıl cache
            'Content-Length' => strlen($pixel),
        ]);
    }
}
