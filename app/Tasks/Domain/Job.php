<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @mixin \Eloquent
 */
class Job extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = $model->uuid ?: (string) Str::uuid();
        });
    }
    public function getResultAttribute($value)
    {
        if($value === null  ) {
        }
        if ($value instanceof Task) {
           return $value;
        } else {
          return Task::createFromArray(json_decode($value, true));
        }
    }

    public function getKeyName(): string
    {
        return 'uuid';
    }
}
