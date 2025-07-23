<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
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
        'status',
        'items_count',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'coupon_code',
        'abandoned_at',
        'converted_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'abandoned_at' => 'datetime',
        'converted_at' => 'datetime',
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
     * Relation avec les articles du panier
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Scope pour les paniers actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Ajouter un produit au panier
     */
    public function addItem(Product $product, $quantity = 1, $pet_id = null)
    {
        $existingItem = $this->items()
            ->where('product_id', $product->id)
            ->where('pet_id', $pet_id)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
            return $existingItem;
        }

        $item = $this->items()->create([
            'product_id' => $product->id,
            'pet_id' => $pet_id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'total_price' => $product->price * $quantity,
        ]);

        $this->recalculate();
        return $item;
    }

    /**
     * Supprimer un article du panier
     */
    public function removeItem($itemId)
    {
        $this->items()->where('id', $itemId)->delete();
        $this->recalculate();
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public function updateItemQuantity($itemId, $quantity)
    {
        $item = $this->items()->find($itemId);
        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->quantity = $quantity;
                $item->total_price = $item->unit_price * $quantity;
                $item->save();
            }
            $this->recalculate();
        }
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        $this->items()->delete();
        $this->recalculate();
    }

    /**
     * Recalculer les totaux du panier
     */
    public function recalculate()
    {
        $items = $this->items()->with('product')->get();
        
        $this->items_count = $items->sum('quantity');
        $this->subtotal = $items->sum('total_price');
        
        $this->tax_amount = 0;
        
        $this->shipping_amount = $this->calculateShipping();
        
        $this->discount_amount = $this->calculateDiscount();
        
        $this->total_amount = $this->subtotal + $this->tax_amount + $this->shipping_amount - $this->discount_amount;
        
        $this->save();
    }

    /**
     * Calculer les frais de livraison
     */
    private function calculateShipping()
    {
        if ($this->subtotal >= 500) {
            return 0;
        }
        
        $hasExpressItems = $this->items()
            ->whereHas('product', function($query) {
                $query->where('shipping_required', true);
            })
            ->exists();
            
        return $hasExpressItems ? 50 : 0; 
    }

    /**
     * Calculer les réductions
     */
    private function calculateDiscount()
    {
        $discount = 0;
        
        if ($this->coupon_code) {
            // Logic pour les coupons
        }
        
        return $discount;
    }

    /**
     * Obtenir le panier actif de l'utilisateur
     */
    public static function getActiveForUser($userId)
    {
        return static::firstOrCreate([
            'user_id' => $userId,
            'status' => 'active'
        ]);
    }

    /**
     * Vérifier si le panier est vide
     */
    public function isEmpty()
    {
        return $this->items_count == 0;
    }

    /**
     * Marquer comme abandonné
     */
    public function markAsAbandoned()
    {
        $this->status = 'abandoned';
        $this->abandoned_at = now();
        $this->save();
    }

    /**
     * Marquer comme converti
     */
    public function markAsConverted()
    {
        $this->status = 'converted';
        $this->converted_at = now();
        $this->save();
    }
}
