<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip_code',
        'subtotal',
        'shipping_cost',
        'tax',
        'total',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });

        static::updating(function ($order) {
            // Detectar cambio de estado a "shipped" (enviado)
            if ($order->isDirty('status') && $order->status === 'shipped') {
                $previousStatus = $order->getOriginal('status');

                // Solo reducir stock si no estaba en shipped antes
                if ($previousStatus !== 'shipped') {
                    // Reducir stock de los productos
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->decrement('stock', $item->quantity);
                        }
                    }
                }
            }

            // Si se cancela una orden que estaba en shipped, restaurar stock
            if ($order->isDirty('status') && $order->status === 'cancelled') {
                $previousStatus = $order->getOriginal('status');

                if ($previousStatus === 'shipped') {
                    // Restaurar stock
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }
                }
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCustomerFullNameAttribute(): string
    {
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }
}
