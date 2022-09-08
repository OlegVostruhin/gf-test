<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\TariffRepository;

class TariffService
{
    public function __construct(public TariffRepository $repository)
    {
    }

    public function checkTariffAllowedForDate(int $tariffId, string $date): bool
    {
        $tariffAvailableDates = $this->repository->getTariffAvailableDates($tariffId);

        return in_array($date, $tariffAvailableDates);
    }
}
