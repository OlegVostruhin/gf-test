<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resourses\TariffCollection;
use App\Repository\TariffRepository;
use Illuminate\Http\Response;

class TariffController extends Controller
{
    public function __construct(private TariffRepository $repository)
    {}

    public function getTariffList(): Response
    {
        $tariffs = $this->repository->getTariffList();

        return response(TariffCollection::collection($tariffs));
    }
}
