<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\TrackingService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected $campaignService;
    protected $trackingService;

    public function __construct(CampaignService $campaignService, TrackingService $trackingService)
    {
        $this->campaignService = $campaignService;
        $this->trackingService = $trackingService;
    }

    /**
     * Kampanya listesi
     */
    public function index()
    {
        $campaigns = $this->campaignService->getUserCampaigns(auth()->id());
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Yeni kampanya oluşturma formu
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Yeni kampanya kaydet
     */
    public function store(CampaignRequest $request)
    {
        $campaign = $this->campaignService->createCampaign($request->validated(), auth()->id());

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Kampanya başarıyla oluşturuldu.');
    }

    /**
     * Kampanya detayları
     */
    public function show(Campaign $campaign)
    {
        // Kullanıcının kendi kampanyası mı kontrol et
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $campaign = $this->campaignService->getCampaignDetails($campaign->id, auth()->id());
        $stats = $this->trackingService->getCampaignStats($campaign->id);

        return view('campaigns.show', compact('campaign', 'stats'));
    }

    /**
     * Kampanya düzenleme formu
     */
    public function edit(Campaign $campaign)
    {
        // Kullanıcının kendi kampanyası mı kontrol et
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Kampanya güncelle
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        // Kullanıcının kendi kampanyası mı kontrol et
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $this->campaignService->updateCampaign($campaign, $request->validated());

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Kampanya başarıyla güncellendi.');
    }

    /**
     * Kampanya sil
     */
    public function destroy(Campaign $campaign)
    {
        // Kullanıcının kendi kampanyası mı kontrol et
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $this->campaignService->deleteCampaign($campaign);

        return redirect()->route('campaigns.index')
            ->with('success', 'Kampanya başarıyla silindi.');
    }
}
