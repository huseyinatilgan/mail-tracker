<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // opened_at için index (zaman bazlı sorgular için)
            $table->index('opened_at');
            
            // campaign_id için index (ilişki sorguları için)
            $table->index('campaign_id');
            
            // IP adresi için index (rate limiting için)
            $table->index('ip_address');
            
            // Composite index (campaign_id + ip_address + opened_at) - rate limiting için
            $table->index(['campaign_id', 'ip_address', 'opened_at'], 'events_rate_limit_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['opened_at']);
            $table->dropIndex(['campaign_id']);
            $table->dropIndex(['ip_address']);
            $table->dropIndex('events_rate_limit_idx');
        });
    }
};

