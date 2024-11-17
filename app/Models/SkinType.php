<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkinType extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'type'
    ];

    const TYPES = [
        'dry' => 'Сухая',
        'oily' => 'Жирная',
        'combination' => 'Комбинированная',
        'sensitive' => 'Чувствительная',
        'normal' => 'Нормальная',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
