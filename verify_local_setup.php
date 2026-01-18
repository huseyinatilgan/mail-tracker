<?php

use App\Models\User;
use App\Models\Campaign;
use App\Models\Event;
use App\Jobs\ProcessTrackingEvent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- MailTracker Local Verification ---\n";

// 1. Create User & Campaign
echo "[1] Creating Test User and Campaign...\n";
$user = User::firstOrCreate(
    ['email' => 'test@mailtracker.local'],
    [
        'name' => 'Test User',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]
);

$campaign = Campaign::create([
    'name' => 'Local Verification Campaign ' . time(),
    'user_id' => $user->id,
    'key_hash' => hash('sha256', 'testkey1234567890123'), // Mock secure key for test (20 chars)
    'encrypted_key' => Crypt::encryptString('testkey1234567890123'),
]);

echo "    Campaign Created: {$campaign->name}\n";
echo "    Key: testkey1234567890123\n";

// 2. Simulate Tracking Request
echo "\n[2] Simulating Tracking Request...\n";
// We initiate the service directly or via HTTP if server is running. 
// To keep it self-contained, let's call the controller logic or service logic directly?
// Actually, calling the route via `call()` is better integration testing.
// But since we are outside PHPUnit, let's use the Service directly to simulate the "Request" part
// or try to hit localhost if running. 
// Let's rely on Service class to ensure we test the logic we wrote.

$service = app(\App\Services\TrackingService::class);
$request = \Illuminate\Http\Request::create('/track/testkey1234567890123', 'GET');
$request->headers->set('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) VerifyBot/1.0');
$request->server->set('REMOTE_ADDR', '127.0.0.99'); // Distinct IP

echo "    Sending Request via TrackingService...\n";
$success = $service->trackEvent('testkey1234567890123', $request);

if ($success) {
    echo "    ✅ TrackingService returned TRUE (Request Accepted)\n";
} else {
    echo "    ❌ TrackingService returned FALSE (Failed)\n";
    exit(1);
}

// 3. Process Queue
echo "\n[3] Processing Queue...\n";
// Since we used 'dispatch', it's likely in the DB or Sync queue depending on .env
// We can try to run the worker for one job or just assert if it's sync.
$envQueue = env('QUEUE_CONNECTION');
echo "    Current Queue Driver: {$envQueue}\n";

if ($envQueue === 'sync') {
    echo "    Queue is SYNC. Job should have processed immediately.\n";
} else {
    echo "    Queue is NOT sync. Running 'queue:work --once' to process job...\n";
    passthru('php artisan queue:work --once');
}

// 4. Verify Database
echo "\n[4] Verifying Database...\n";
$event = Event::where('campaign_id', $campaign->id)->latest()->first();

if ($event) {
    echo "    ✅ Event Found!\n";
    echo "       ID: {$event->id}\n";
    echo "       IP Hash: {$event->ip_hash} (Should be hashed)\n";
    echo "       UA Hash: {$event->ua_hash}\n";
    echo "       Is Proxy: " . ($event->is_proxy ? 'Yes' : 'No') . "\n";
} else {
    echo "    ❌ Event NOT Found in Database.\n";
    exit(1);
}

// Cleanup
$campaign->delete();
// $user->delete(); // Keep user for inspection if needed.

echo "\n✨ Verification Completed Successfully!\n";
