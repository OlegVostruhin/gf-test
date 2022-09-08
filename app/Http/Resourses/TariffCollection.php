<?php

declare(strict_types=1);

namespace App\Http\Resourses;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property array $dates
 * @property int $id
 * @property string $name
 * @property float $price
 */
class TariffCollection extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'dates' => $this->dates
        ];
    }
}
