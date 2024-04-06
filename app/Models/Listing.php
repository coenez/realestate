<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'];

    private array $validations = [];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFiltered(Builder $query, array $filters): Builder
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
        return $query;
    }
}
