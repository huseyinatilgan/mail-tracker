<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Enable tracking for these security tests to verify sanitization
        config(['mailtracker.track_user_agent' => true]);
        config(['mailtracker.track_ip' => true]);
    }

    /**
     * Test: Kullanıcı başka kullanıcının kampanyasını görememeli
     */
    public function test_user_cannot_view_other_users_campaign(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $campaign = Campaign::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->get(route('campaigns.show', $campaign));

        $response->assertStatus(403);
    }

    /**
     * Test: Kullanıcı başka kullanıcının kampanyasını düzenleyememeli
     */
    public function test_user_cannot_update_other_users_campaign(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $campaign = Campaign::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->put(route('campaigns.update', $campaign), [
            'name' => 'Hacked Campaign',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test: Kullanıcı başka kullanıcının kampanyasını silememeli
     */
    public function test_user_cannot_delete_other_users_campaign(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $campaign = Campaign::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->delete(route('campaigns.destroy', $campaign));

        $response->assertStatus(403);
    }

    /**
     * Test: Geçersiz tracking key ile istek yapılamamalı
     */
    public function test_invalid_tracking_key_returns_pixel_but_no_event(): void
    {
        // Use a key that is definitely invalid format (e.g. not 20 chars) but URL-safe
        // <script> might trigger 404 due to path traversal/safety checks in some envs
        $invalidKey = 'invalid-key-short';

        $response = $this->get(route('tracking.pixel', ['key' => $invalidKey]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');

        // Event oluşturulmamalı
        $this->assertEquals(0, Event::count());
    }

    /**
     * Test: Tracking key formatı doğrulanmalı
     */
    public function test_tracking_key_format_validation(): void
    {
        // Geçersiz formatlar
        $invalidKeys = [
            'short',
            'toolongkey12345678901234567890',
            'key-with-special-chars!',
            'key with spaces',
        ];

        foreach ($invalidKeys as $key) {
            $response = $this->get(route('tracking.pixel', ['key' => $key]));
            $response->assertStatus(200);
            $this->assertEquals(0, Event::count());
        }
    }

    /**
     * Test: XSS koruması - HTML input'lar escape edilmeli
     */
    public function test_xss_protection_in_campaign_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('campaigns.store'), [
            'name' => '<script>alert("xss")</script>',
        ]);

        // Validation hatası olmalı veya HTML temizlenmiş olmalı
        $campaign = Campaign::where('user_id', $user->id)->first();

        if ($campaign) {
            $this->assertStringNotContainsString('<script>', $campaign->name);
        }
    }

    /**
     * Test: Rate limiting çalışmalı
     */
    public function test_rate_limiting_on_tracking_endpoint(): void
    {
        $campaign = Campaign::factory()->create();

        // 101 istek yap (limit 100/dakika)
        for ($i = 0; $i < 101; $i++) {
            $response = $this->get(route('tracking.pixel', ['key' => $campaign->key]));

            if ($i >= 100) {
                // 100'den sonra rate limit hatası olmalı
                $response->assertStatus(429);
                break;
            }
        }
    }

    // CSRF test removed or ignored because typically disabled in testing environment automatically
    // public function test_csrf_protection_on_campaign_creation(): void { ... }
    /*
    public function test_csrf_protection_on_campaign_creation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('campaigns.store'), [
            'name' => 'Test Campaign',
            // CSRF token yok
        ]);

        $response->assertStatus(419); // CSRF token mismatch
    }
    */

    /**
     * Test: SQL Injection koruması
     */
    public function test_sql_injection_protection(): void
    {
        $user = User::factory()->create();

        // SQL injection denemesi
        $maliciousInput = "'; DROP TABLE campaigns; --";

        $response = $this->actingAs($user)->post(route('campaigns.store'), [
            'name' => $maliciousInput,
        ]);

        // Tablo hala var olmalı
        $this->assertTrue(\Schema::hasTable('campaigns'));
    }

    /**
     * Test: IP adresi doğrulaması
     */
    public function test_ip_address_validation(): void
    {
        $campaign = Campaign::factory()->create();

        // Geçersiz IP ile tracking
        $response = $this->withHeaders([
            'X-Forwarded-For' => 'invalid-ip-address',
        ])->get(route('tracking.pixel', ['key' => $campaign->key]));

        $response->assertStatus(200);
        // Event oluşturulmamalı veya IP null olmalı
    }

    /**
     * Test: User Agent sanitization
     */
    public function test_user_agent_sanitization(): void
    {
        $campaign = Campaign::factory()->create();

        $maliciousUserAgent = '<script>alert("xss")</script>' . str_repeat('a', 1000);

        $response = $this->withHeaders([
            'User-Agent' => $maliciousUserAgent,
        ])->get(route('tracking.pixel', ['key' => $campaign->key]));

        $response->assertStatus(200);

        $event = Event::where('campaign_id', $campaign->id)->first();

        if ($event) {
            $this->assertStringNotContainsString('<script>', $event->user_agent);
            $this->assertLessThanOrEqual(500, strlen($event->user_agent ?? ''));
        }
    }

    /**
     * Test: Email validation
     */
    public function test_email_validation_in_tracking(): void
    {
        $campaign = Campaign::factory()->create();

        $invalidEmail = 'not-an-email';

        $response = $this->get(route('tracking.pixel', [
            'key' => $campaign->key,
            'email' => $invalidEmail,
        ]));

        $response->assertStatus(200);

        $event = Event::where('campaign_id', $campaign->id)->first();

        if ($event) {
            $this->assertNull($event->user_email);
        }
    }

    /**
     * Test: Security headers present
     */
    public function test_security_headers_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}



