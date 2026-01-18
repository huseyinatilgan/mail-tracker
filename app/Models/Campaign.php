<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        // 'key', // Plaintext key removed
        'key_hash',
        'encrypted_key',
        'user_id',
    ];

    /**
     * Tarih alanları için cast tanımlamaları
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Kampanyanın sahibi kullanıcı ilişkisi
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kampanyanın event ilişkisi
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get decrypted key attribute
     */
    public function getKeyAttribute()
    {
        if (isset($this->attributes['encrypted_key'])) {
            try {
                return \Illuminate\Support\Facades\Crypt::decryptString($this->attributes['encrypted_key']);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }
}
