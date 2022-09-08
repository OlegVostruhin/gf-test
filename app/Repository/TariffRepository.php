<?php

namespace App\Repository;

use App\Models\Tariff;
use Illuminate\Database\Eloquent\Collection;

class TariffRepository
{
    public function getTariffList(): Collection
    {
        return Tariff::all();
    }

    public function getTariffAvailableDates(int $tariffId): array
    {
        return Tariff::where('id', $tariffId)->first()->dates;
    }
}
