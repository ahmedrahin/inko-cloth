<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrintfulService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.printful.base_url');
        $this->apiKey  = config('services.printful.key');
    }

    /**
     * Send order to Printful
     */
    public function createOrder(Order $order): bool
    {
        try {
            $payload = $this->buildOrderPayload($order);

            $response = Http::withToken($this->apiKey)
                ->acceptJson()
                ->post($this->baseUrl . '/orders', $payload);

            if (!$response->successful()) {
                Log::error('Printful order failed', [
                    'order_id' => $order->id,
                    'response' => $response->body(),
                ]);

                return false;
            }

            $result = $response->json('result');

            // Save Printful reference
            $order->update([
                'printful_order_id'   => $result['id'] ?? null,
                'fulfillment_status'  => 'sent_to_printful',
            ]);

            return true;

        } catch (\Throwable $e) {
            Log::error('Printful API exception', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Build payload for Printful API
     */
    protected function buildOrderPayload(Order $order): array
    {
        $items = [];

        foreach ($order->orderItems as $item) {
            if (!$item->product?->printful_variant_id) {
                continue;
            }

            $items[] = [
                'variant_id' => (int) 444,
                'quantity'   => (int) $item->quantity,
            ];
        }

        return [
            'external_id' => $order->order_id, // your order reference
            'recipient' => [
                'name'    => $order->name,
                'address1'=> $order->shipping_address,
                'city'    => $order->city,
                'zip'     => $order->zip_code,
                'country_code' => 'BD',
                'phone'   => $order->phone,
                'email'   => $order->email,
            ],
            'items' => $items,
        ];
    }

    /**
     * Get shipping rates (for checkout)
     */
    public function getShippingRates(array $items, array $address)
    {
        $payload = [
            'recipient' => $address,
            'items' => $items,
        ];

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->post($this->baseUrl . '/shipping/rates', $payload);

        return $response->json('result') ?? [];
    }
}
