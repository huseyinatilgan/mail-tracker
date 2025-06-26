<?php

namespace App\Http\Controllers;

use App\Services\TrackingService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Dashboard ana sayfası
     */
    public function index()
    {
        $stats = $this->trackingService->getDashboardStats(auth()->id());
        
        // Son 5 kampanyayı getir
        $recentCampaigns = auth()->user()->campaigns()
            ->withCount('events')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentCampaigns'));
    }
}
