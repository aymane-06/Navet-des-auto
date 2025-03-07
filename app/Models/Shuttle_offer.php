<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shuttle_offer extends Model
{
    /** @use HasFactory<\Database\Factories\ShuttleOfferFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'shuttle_offer_tag');
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('status', 'active');
    }

    public function isFull()
    {
        return $this->current_subscribers >= $this->max_subscribers;
    }
    public function getCasts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
}
