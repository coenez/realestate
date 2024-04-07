<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    protected $appends = ['src'];

    public const VALIDATIONS = [
        ['images.*' => 'mimes:jpg,png,jpeg|max:5000'],
        [
            'images.*.mimes' => 'The file should be in one of the following formats: jpg, png, jpeg',
            'images.*.max' => 'The file can have a filesize of maximum 5mb'
        ]
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function getSrcAttribute() {
        return asset("storage/{$this->filename}");
    }
}
