<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $message
 * @property boolean $processed
 * @property User $user
 * @property int $user_id
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 */
class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedbacks';

    protected $fillable = [
        'name',
        'message',
        'phone',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function setPhoneAttribute($value): array|string|null
    {
        return $this->attributes['phone'] = preg_replace("/[^0-9]/", "", $value);
    }
}
