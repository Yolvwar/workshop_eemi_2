<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_phone',
        'shipping_address_line_1',
        'shipping_address_line_2',
        'shipping_city',
        'shipping_postal_code',
        'shipping_notes',
        'shipping_method',
        'estimated_delivery_date',
        'actual_delivery_date',
        'placed_at',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
        'coupon_code',
        'customer_notes',
        'admin_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'placed_at' => 'datetime',
        'confirmed_at' => 'datetime', 
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'estimated_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
    ];

    /**
     * Boot the model and generate UUID.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (empty($model->order_number)) {
                $model->order_number = 'AP' . date('Y') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les articles de la commande
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scopes pour les différents statuts
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Créer une commande à partir d'un panier
     */
    public static function createFromCart(Cart $cart, array $shippingData, array $billingData = null)
    {
        $billingData = $billingData ?: $shippingData;

        $nameParts = explode(' ', $shippingData['name'], 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $order = static::create([
            'user_id' => $cart->user_id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $cart->subtotal,
            'tax_amount' => $cart->tax_amount,
            'shipping_amount' => $cart->shipping_amount,
            'discount_amount' => $cart->discount_amount,
            'total_amount' => $cart->total_amount,
            'shipping_first_name' => $firstName,
            'shipping_last_name' => $lastName,
            'shipping_phone' => $shippingData['phone'],
            'shipping_address_line_1' => $shippingData['address_line_1'],
            'shipping_address_line_2' => $shippingData['address_line_2'] ?? null,
            'shipping_city' => $shippingData['city'],
            'shipping_postal_code' => $shippingData['postal_code'] ?? null,
            'coupon_code' => $cart->coupon_code,
        ]);

        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'pet_id' => $cartItem->pet_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'total_price' => $cartItem->total_price,
                'product_name' => $cartItem->product->name,
                'product_sku' => $cartItem->product->sku,
            ]);
        }

        $cart->markAsConverted();

        return $order;
    }

    /**
     * Confirmer la commande
     */
    public function confirm()
    {
        $this->status = 'confirmed';
        $this->payment_status = 'paid';
        $this->confirmed_at = now();
        
        $this->save();
    }

    /**
     * Expédier la commande
     */
    public function ship($trackingNumber = null)
    {
        $this->status = 'shipped';
        $this->shipped_at = now();
        $this->save();
    }

    /**
     * Livrer la commande
     */
    public function deliver()
    {
        $this->status = 'delivered';
        $this->delivered_at = now();
        $this->save();
    }

    /**
     * Annuler la commande
     */
    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();
    }

    /**
     * Obtenir le statut avec badge coloré
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['text' => 'En attente', 'class' => 'bg-yellow-100 text-yellow-800'],
            'confirmed' => ['text' => 'Confirmée', 'class' => 'bg-blue-100 text-blue-800'],
            'shipped' => ['text' => 'Expédiée', 'class' => 'bg-purple-100 text-purple-800'],
            'delivered' => ['text' => 'Livrée', 'class' => 'bg-green-100 text-green-800'],
            'cancelled' => ['text' => 'Annulée', 'class' => 'bg-red-100 text-red-800'],
        ];

        return $badges[$this->status] ?? ['text' => 'Inconnu', 'class' => 'bg-gray-100 text-gray-800'];
    }

    /**
     * Vérifier si la commande peut être annulée
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Obtenir l'adresse de livraison complète
     */
    public function getFullShippingAddressAttribute()
    {
        $address = $this->shipping_address_line_1;
        if ($this->shipping_address_line_2) {
            $address .= ', ' . $this->shipping_address_line_2;
        }
        $address .= ', ' . $this->shipping_city;
        if ($this->shipping_postal_code) {
            $address .= ' ' . $this->shipping_postal_code;
        }
        $address .= ', UAE'; // Default country
        
        return $address;
    }
}
