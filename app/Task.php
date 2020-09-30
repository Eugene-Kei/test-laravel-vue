<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 * @package App
 *
 * @property int $creator_id
 * @property int $executor_id
 * @property int $id
 * @property int $price
 * @property int $status
 * @property string $completed_at
 * @property string $created_at
 * @property string $description
 * @property string $name
 * @property string $updated_at
 */
class Task extends Model
{
    const STATUS_NEW = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_ON_CHECK = 3;
    const STATUS_COMPLETED = 4;

    const STATUS_VALUES = [
        self::STATUS_NEW,
        self::STATUS_IN_WORK,
        self::STATUS_ON_CHECK,
        self::STATUS_COMPLETED,
    ];

    protected $fillable = [
        'name', 'description', 'price', 'status', 'creator_id', 'executor_id'
    ];

    /**
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return BelongsTo
     */
    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id');
    }
}
