<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $soratble = [
        'price', 'created_at'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'by_user_id'
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(
            ListingImage::class
        );
    }

    public function offers(): HasMany
    {
        return $this->hasMany(
            Offer::class,
            'listing_id'
        );
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeWithoutSold(Builder $query): Builder
    {
        return $query->whereNull('sold_at');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['priceFrom'] ?? false, function ($query, $priceFrom) {
            return $query->where('price', '>=', $priceFrom);
        })->when($filters['priceTo'] ?? false, function ($query, $priceTo) {
            return $query->where('price', '<=', $priceTo);
        })->when($filters['beds'] ?? false, function ($query, $beds) {
            return $query->where('beds', (int)$beds < 6 ? '=' : '>=', $beds);
        })->when($filters['baths'] ?? false, function ($query, $baths) {
            return $query->where('baths', (int)$baths < 6 ? '=' : '>=', $baths);
        })->when($filters['areaFrom'] ?? false, function ($query, $areaFrom) {
            return $query->where('area', '>=', $areaFrom);
        })->when($filters['areaTo'] ?? false, function ($query, $areaTo) {
            return $query->where('area', '<=', $areaTo);
        })->when($filters['deleted'] ?? false, function ($query) {
            return $query->withTrashed();
        })->when($filters['by'] ?? false, fn ($query, $by) => $query->orderBy($by, $filters['order'] ?? 'desc'));
    }
}
