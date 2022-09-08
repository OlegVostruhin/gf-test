<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\TariffNotAllowedException;
use App\Repository\OrderRepository;

class OrderService
{
    public function __construct(private OrderRepository $orderRepository, private TariffService $tariffService)
    {
    }

    public function createOrder(string $deliveryDate, string $deliveryAddress, int $clientId, int $tariffId)
    {
        $isTariffAllowedForDate = $this->tariffService->checkTariffAllowedForDate($tariffId, $deliveryDate);

        if (!$isTariffAllowedForDate) {
            throw new TariffNotAllowedException();
        }

        return $this->orderRepository->createOrder($deliveryDate, $deliveryAddress, $clientId, $tariffId);
    }
}
