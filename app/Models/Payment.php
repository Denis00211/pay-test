<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Payment
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $uuid
 * @property float $amount
 * @property int $status
 * @property \DateTime|null $created_date
 * @property \DateTime|null $payment_date
 * @property string $phone
 * @property string $email
 * @property string $card_first_six
 * @property string $card_last_four
 */
class Payment extends Model
{
    use SoftDeletes;

    public const STATUS_CREATED = 1;
    public const STATUS_SUCCESS = 2;
    public const STATUS_FAILED = 3;

    protected $fillable = [
        'user_id',
        'uuid',
        'amount',
        'status',
        'created_date',
        'payment_date',
        'phone',
        'email',
        'card_first_six',
        'card_last_four',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'payment_date' => 'datetime',
    ];

    public static function getStatuses(): array
    {
        return [
           self::STATUS_CREATED => 'created',
           self::STATUS_SUCCESS => 'success',
           self::STATUS_FAILED => 'failed'
        ];
    }

    public function getStatusText(): string
    {
        return self::getStatuses()[$this->status] ?? '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCurrency():string
    {
        return 'тг';
    }

    public function checkPaid(): bool
    {
        return in_array($this->status, [self::STATUS_FAILED, self::STATUS_SUCCESS]);
    }

    public function checkSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function checkFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function cutAmount(float $amount, int $len): float
    {
        return floor(round($amount * (10 ** $len), $len)) / (10 ** $len);
    }
}
