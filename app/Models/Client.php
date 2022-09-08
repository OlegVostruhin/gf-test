<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static updateOrCreate(string[] $array, string[] $array1)
 * @property int $id
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'phone', 'name'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
