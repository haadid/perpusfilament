<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibrarianActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'librarian_id',
        'transaction_id',
        'user_id',
        'book_id',
        'action',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'librarian_id' => 'integer',
        'transaction_id' => 'integer',
        'user_id' => 'integer',
        'book_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
