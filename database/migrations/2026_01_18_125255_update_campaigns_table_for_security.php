<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('key_hash', 64)->nullable()->after('key');
            $table->text('encrypted_key')->nullable()->after('key_hash');
        });

        // Migrate existing keys
        // Note: We use cursor() to handle larger datasets somewhat more efficiently,
        // though for very large datasets this should be a job.
        DB::table('campaigns')->orderBy('id')->cursor()->each(function ($campaign) {
            DB::table('campaigns')->where('id', $campaign->id)->update([
                'key_hash' => hash('sha256', $campaign->key),
                'encrypted_key' => Crypt::encryptString($campaign->key),
            ]);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            // Make columns required
            $table->string('key_hash', 64)->nullable(false)->change();
            $table->text('encrypted_key')->nullable(false)->change();

            // Add unique index on hash
            $table->unique('key_hash');

            // Drop old key column
            $table->dropColumn('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('key', 20)->nullable()->after('id');
        });

        // Restore keys
        DB::table('campaigns')->orderBy('id')->cursor()->each(function ($campaign) {
            try {
                $key = Crypt::decryptString($campaign->encrypted_key);
                DB::table('campaigns')->where('id', $campaign->id)->update([
                    'key' => $key,
                ]);
            } catch (\Exception $e) {
                // If decryption fails, we can't restore the original key easily.
                // In a real scenario, we might want to log this.
            }
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('key', 20)->nullable(false)->unique()->change();
            $table->dropColumn(['key_hash', 'encrypted_key']);
        });
    }
};
