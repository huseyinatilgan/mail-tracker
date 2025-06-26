<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'campaign_id',
        'user_agent',
        'ip_address',
        'user_email',
        'opened_at',
    ];

    /**
     * Tarih alanları için cast tanımlamaları
     */
    protected $casts = [
        'opened_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Event'in ait olduğu kampanya ilişkisi
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
