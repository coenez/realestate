<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
