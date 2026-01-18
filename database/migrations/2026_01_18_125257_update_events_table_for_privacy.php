<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // New privacy-preserving columns
            $table->string('ip_hash', 64)->nullable()->after('ip_address')->index();
            $table->string('ua_hash', 64)->nullable()->after('user_agent');

            // Proxy detection
            $table->boolean('is_proxy')->default(false)->after('ua_hash');
            $table->string('proxy_type')->nullable()->after('is_proxy'); // 'apple_privacy', 'gmail_image_proxy', etc.

            // Make original PII columns nullable (they will be optional via config)
            $table->string('ip_address')->nullable()->change();
            $table->text('user_agent')->nullable()->change();

            // Performance indexes
            // Composite index for common queries: filtering by campaign and date range
            $table->index(['campaign_id', 'opened_at']);
            // Composite index for deduplication checks: campaign + IP hash + date range
            $table->index(['campaign_id', 'ip_hash', 'opened_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['campaign_id', 'opened_at']);
            $table->dropIndex(['campaign_id', 'ip_hash', 'opened_at']);

            $table->dropColumn(['ip_hash', 'ua_hash', 'is_proxy', 'proxy_type']);

            // We can't easily revert nullable change without potentially failing on existing nulls,
            // but strictly speaking 'down' should try to restore state. 
            // We'll leave them nullable as strict revert might be impossible if data was added.
            // But let's try to set default if tracking was disabled? No, unsafe.
            // Just leaving them nullable is acceptable for this scope.
        });
    }
};
