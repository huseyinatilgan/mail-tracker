<?php

namespace App\Http\Controllers;

use App\Services\TrackingService;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        // Son 7 günlük grafik verileri
        $chartData = $this->getChartData(auth()->id());

        return view('dashboard.index', compact('stats', 'recentCampaigns', 'chartData'));
    }

    /**
     * Son 7 günlük grafik verilerini getir
     */
    private function getChartData(int $userId)
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            
            // O günün okunma sayısını al
            $count = \App\Models\Event::whereHas('campaign', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereDate('opened_at', $date->format('Y-m-d'))->count();
            
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
