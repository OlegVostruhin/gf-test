<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\TariffNotAllowedException;
use App\Http\Requests\CreateOrderRequest;
use App\Services\ClientService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(private ClientService $clientService, private OrderService $orderService)
    {
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {
        try {
            $client = $this->clientService->updateOrCreate($request->phone, $request->name);
            $this->orderService->createOrder($request->date, $request->deliveryAddress, $client->id, $request->tariffId);
        } catch (TariffNotAllowedException $e) {
            return response()->json([
                'success' => -1,
                'message' => 'Tariff is not allowed for the date',
                'errors' => ['Выбранный тариф недоступен для выбранной даты']
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e->getTraceAsString()]);
            return response()->json([
                'success' => -1,
                'message' => 'Something went wrong',
                'errors' => ['Не удалось создать заказ']
            ]);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Order created successfully',
            'errors' => []
        ]);
    }
}
