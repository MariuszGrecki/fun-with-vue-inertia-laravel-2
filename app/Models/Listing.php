<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder<Listing> mostRecent()
 * @method static Builder<Listing> filter(array<string, mixed> $filters)
 */
class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'beds',
        'baths',
        'area',
        'city',
        'code',
        'street',
        'street_nr',
        'price',
    ];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    #[Scope]
    protected function mostRecent(Builder $query): Builder {
        return $query->orderByDesc('created_at');
    }

    #[Scope]
    protected function filter(Builder $query, array $filters): Builder {
        return $query->when(
                $filters['priceFrom'] ?? null,
                fn ($query, $value) => $query->where('price', '>=', $value)
            )->when(
                $filters['priceTo'] ?? null,
                fn ($query, $value) => $query->where('price', '<=', $value)
            )->when(
                $filters['beds'] ?? null,
                fn ($query, $value) => $query->where('beds', (int)$value > 6 ? '>' : '=', $value)
            )->when(
                $filters['baths'] ?? null,
                fn ($query, $value) => $query->where('baths', (int)$value > 6 ? '>' : '=', $value)
            )->when(
                $filters['areaFrom'] ?? null,
                fn ($query, $value) => $query->where('area', '>=', $value)
            )->when(
                $filters['areaTo'] ?? null,
                fn ($query, $value) => $query->where('area', '<=', $value)
            );
    }
}
