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
        $summary = $this->campaignService->getUserCampaignSummary(auth()->id());

        return view('campaigns.index', compact('campaigns', 'summary'));
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
        $this->authorize('view', $campaign);

        $campaign = $this->campaignService->getCampaignDetails($campaign->id, auth()->id());
        $stats = $this->trackingService->getCampaignStats($campaign->id);

        return view('campaigns.show', compact('campaign', 'stats'));
    }

    /**
     * Kampanya düzenleme formu
     */
    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Kampanya güncelle
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->campaignService->updateCampaign($campaign, $request->validated());

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Kampanya başarıyla güncellendi.');
    }

    /**
     * Kampanya sil
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $this->campaignService->deleteCampaign($campaign);

        return redirect()->route('campaigns.index')
            ->with('success', 'Kampanya başarıyla silindi.');
    }
}
