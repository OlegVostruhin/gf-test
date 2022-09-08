<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Client;
use App\Repository\ClientRepository;

class ClientService
{
    public function __construct(private ClientRepository $repository)
    {
    }

    public function updateOrCreate(string $phone, string $name): Client
    {
        return $this->repository->updateOrCreate($phone, $name);
    }
}
