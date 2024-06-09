<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_code',
        'title',
        'slug',
        'isbn',
        'year',
        'description',
        'cover',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function publishers(): BelongsToMany
    {
        return $this->belongsToMany(Publisher::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function bookEdits(): HasMany
    {
        return $this->hasMany(BookEdit::class);
    }

    public function librarianActivities(): HasMany
    {
        return $this->hasMany(LibrarianActivity::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function validationBooks(): HasMany
    {
        return $this->hasMany(ValidationBook::class);
    }

    // create inventory when book is created
    protected static function boot(): void
    {
        parent::boot();
        static::created(function ($book) {
            $book->inventory()->create([
                'book_code' => $book->book_code,
                'slug' => $book->slug,
            ]);
        });
    }

}
