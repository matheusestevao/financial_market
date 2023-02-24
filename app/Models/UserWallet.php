<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class UserWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_transaction_id',
        'category_id',
        'ticker',
        'amount'
    ];

    /**
	 *  Setup model event hooks
	 */
	protected static function boot()
	{
	    parent::boot();

	    self::creating(function ($model) {
	        $model->id = (string) Uuid::uuid4();
	    });
	}

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function typeTransactions(): BelongsTo
    {
        return $this->belongsTo(TypeTransaction::class, 'type_transaction_id', 'id');
    }
}
