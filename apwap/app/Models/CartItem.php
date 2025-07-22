<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartItem extends Model
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
        'cart_id',
        'product_id',
        'pet_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
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

        static::updated(function ($model) {
            $model->cart->recalculate();
        });

        static::deleted(function ($model) {
            $model->cart->recalculate();
        });
    }

    /**
     * Relation avec le panier
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relation avec le produit
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation avec l'animal (optionnel)
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Calculer le total de l'article
     */
    public function calculateTotal()
    {
        $this->total_price = $this->unit_price * $this->quantity;
        $this->save();
    }

    /**
     * Vérifier si le produit est toujours en stock
     */
    public function isInStock()
    {
        return $this->product && $this->product->stock_quantity >= $this->quantity;
    }

    /**
     * Obtenir le nom du produit
     */
    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : 'Produit supprimé';
    }

    /**
     * Obtenir l'image du produit
     */
    public function getProductImageAttribute()
    {
        return $this->product ? $this->product->main_image : null;
    }
}
