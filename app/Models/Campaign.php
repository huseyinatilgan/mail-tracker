<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'key',
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
}
