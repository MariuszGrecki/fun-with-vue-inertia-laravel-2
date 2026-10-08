<?php

namespace App\Models;

use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    /** @use HasFactory<OfferFactory> */
    use HasFactory;

    protected $fillable = ['amount', 'accepted_at', 'rejected_at'];

    /**
     * @return BelongsTo<Listing, $this>
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }

    /**
     * @param  Builder<Offer>  $query
     * @return Builder<Offer>
     */
    #[Scope]
    protected function createdByMe(Builder $query): Builder
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }
}
