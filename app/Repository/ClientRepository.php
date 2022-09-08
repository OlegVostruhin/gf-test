<?php

namespace App\Repository;

use App\Models\Client;

class ClientRepository
{
    public function updateOrCreate(string $phone, string $name): Client
    {
        return Client::updateOrCreate(
            ['phone' => $phone],
            [
                'name' => $name,
                'phone' => $phone
            ]
        );
    }
}
