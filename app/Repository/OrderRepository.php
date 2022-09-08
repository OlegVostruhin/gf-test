<?php

namespace App\Repository;

use App\Models\Order;

class OrderRepository
{
    public function createOrder(string $deliveryDate, string $deliveryAddress, int $clientId, int $tariffId) {
        return Order::create([
            'delivery_date' => $deliveryDate,
            'delivery_address' => $deliveryAddress,
            'client_id' =>  $clientId,
            'tariff_id' => $tariffId
        ]);
    }

}
