<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'];

    public const VALIDATIONS = [
        'beds' => 'required|integer|min:0|max:20',
        'baths' => 'required|integer|min:0|max:20',
        'area' => 'required|integer|min:15|max:1500',
        'city' => 'required',
        'code' => 'required',
        'street' => 'required',
        'street_nr' => 'required|min:1|max:1000',
        'price' => 'required|integer|min:1|max:20000000',
    ];

    public const FILTERS = [
        'priceFrom' => ['>=', 'price'],
        'priceTo' => ['<=', 'price'],
        'beds' => ['=', 'beds'],
        'baths' => ['=', 'baths'],
        'areaFrom' => ['>=', 'areaFrom'],
        'areaTo' => ['<=', 'areaTo'],
        'deleted' => ['=', 'deleted_at'],
    ];

    protected const SORTERS = [
        'price',
        'created_at'
    ];

    public const PAGE_SIZE = 10;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'listing_id');
    }

    public function scopeWithoutSold(Builder $query): Builder
    {
//        return $query->doesntHave('offers')->orWhereHas('offers', function(Builder $query) {
//            $query->whereNull('accepted_at')->whereNull('rejected_at');
//        });
        return $query->whereNull('sold_at');
    }

    public function scopeFiltered(Builder $query, array $filters, array $sorter = []): Builder
    {
        foreach(self::FILTERS as $filterName => $properties) {
            list($operator, $field) = $properties;

            $query->when(
                $filters[$filterName] ?? false,
                static function($query, $value) use($field, $operator) {
                    //handle 6+ value with correct operator
                    if (in_array($field, ['beds', 'baths']) && (int)$value === 6) {
                        $operator = '>=';
                    }
                    if ($field === 'deleted_at') {
                        $query->withTrashed();
                    } else {
                        $query->where($field, $operator, $value);
                    }
                }
            );
        }
        if (isset($sorter['by']) && in_array($sorter['by'], self::SORTERS)) {
            $direction = isset($sorter['order']) && in_array($sorter['order'], ['asc', 'desc'], true) ? $sorter['order'] : 'asc';
            $query->orderBy($sorter['by'], $direction);
        }
        return $query;
    }
}
