<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'issued_at',
        'amount',
        'is_paid',
        'paid_at',
        'reason',
        'original_fine_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'book_id' => 'integer',
        'issued_at' => 'datetime',
        'amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'original_fine_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function originalFine(): BelongsTo
    {
        return $this->belongsTo(Fine::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->replace(',', ''),
        );
    }
}
