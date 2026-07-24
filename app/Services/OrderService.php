<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder($user, array $data, $cartItems, $subtotal, $shippingCost = 10.00, $discountAmount = 0.00)
    {
        return DB::transaction(function () use ($user, $data, $cartItems, $subtotal, $shippingCost, $discountAmount) {
            $taxAmount = round($subtotal * 0.05, 2); // 5% tax
            $totalAmount = max(0, $subtotal + $shippingCost + $taxAmount - $discountAmount);

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $user ? $user->id : null,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'cod',
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'shipping_address' => [
                    'full_name' => $data['shipping_full_name'] ?? ($user->name ?? ''),
                    'address_line_1' => $data['shipping_address_line_1'] ?? '',
                    'city' => $data['shipping_city'] ?? '',
                    'state' => $data['shipping_state'] ?? '',
                    'postal_code' => $data['shipping_postal_code'] ?? '',
                    'country' => $data['shipping_country'] ?? 'USA',
                    'phone' => $data['shipping_phone'] ?? '',
                ],
                'billing_address' => [
                    'full_name' => $data['billing_full_name'] ?? ($data['shipping_full_name'] ?? ''),
                    'address_line_1' => $data['billing_address_line_1'] ?? ($data['shipping_address_line_1'] ?? ''),
                    'city' => $data['billing_city'] ?? ($data['shipping_city'] ?? ''),
                    'state' => $data['billing_state'] ?? ($data['shipping_state'] ?? ''),
                    'postal_code' => $data['billing_postal_code'] ?? ($data['shipping_postal_code'] ?? ''),
                    'country' => $data['billing_country'] ?? ($data['shipping_country'] ?? 'USA'),
                    'phone' => $data['billing_phone'] ?? ($data['shipping_phone'] ?? ''),
                ],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;
                $price = $product->sale_price ?? $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'total' => $price * $item->quantity,
                ]);

                // Decrement stock
                if ($product->stock_quantity >= $item->quantity) {
                    $product->decrement('stock_quantity', $item->quantity);
                }
            }

            return $order;
        });
    }
}
