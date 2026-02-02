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

            $response = Http::withToken($this->apiKey)->acceptJson()->post($this->baseUrl . '/orders', $payload);


            if (!$response->successful()) {
                Log::error('Printful order failed', [
                    'order_id' => $order->id,
                    'response' => $response->body(),
                ]);

                dd($response->body());
                return false;
            }

            dd($response->body());
            Log::info('Printful order created', [
                'order_id' => $order->id,
                'response' => $response->body(),
            ]);

            $result = $response->json('result');

            // Save Printful reference
            // $order->update([
            //     'printful_order_id'   => $result['id'] ?? null,
            //     'fulfillment_status'  => 'sent_to_printful',
            // ]);

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
            // if (!$item->product?->printful_variant_id) {
            //     continue;
            // }

            $items[] = [
                'variant_id' => '#6976601b42d574',
                'quantity'   => (int) $item->quantity,
                'name'   => $item->product->name ?? 'Unknown Product',
                'price'  => (float) $item->price,
                'retail_price'  => (float) $item->price,
                'image'  => 'https://inkyclothing.com/uploads/product_images/1768774185_4.png',
                // 'image' => asset($item->product->thumb_image ?? ''),
                'files' => [
                    [
                        'type' => 'default',
                        'url'  => 'https://inkyclothing.com/uploads/product_images/1768774185_4.png'
                    ]
                ]
            ];

        }
        

        return [
            'external_id' => $order->order_id,
            'recipient' => [
                'name'    => $order->name,
                'address1'=> $order->shipping_address,
                'city'    => $order->city ?? null,
                'state_code' => 'CA',
                'zip'     => $order->zip_code ?? null,
                'country_code' => 'US',
                'phone'   => $order->phone,
                'email'   => $order->email ?? null,
            ],

            'retail_costs' => [
                'currency'    => 'USD',
                'subtotal'    => (float) $order->subtotal,
                'discount'    => (float) $order->coupon_discount,
                'shipping'    => (float) $order->shipping_cost,
                'tax'         => 0,
                'total'       => (float) $order->grand_total,
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
