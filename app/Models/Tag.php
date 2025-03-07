<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public function shuttleOffers()
    {
        return $this->belongsToMany(Shuttle_Offer::class, 'shuttle_offer_tag');
    }
}
