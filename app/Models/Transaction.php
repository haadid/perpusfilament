<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
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
        'requested_at',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
        'type',
        'reason',
        'original_transaction_id',
        'transaction_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requested_at' => 'datetime',
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'status' => TransactionStatus::class,
        'type' => TransactionType::class,
        'returned_at' => 'datetime',
        'transaction_id' => 'integer',
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

    public function originalTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
