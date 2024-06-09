<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookEdit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'title',
        'isbn',
        'year',
        'slug',
        'description',
        'cover',
        'genres',
        'categories',
        'authors',
        'publishers',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'book_id' => 'integer',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function validationBooks(): HasMany
    {
        return $this->hasMany(ValidationBook::class);
    }
}
