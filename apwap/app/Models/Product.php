<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
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
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'barcode',
        'category_id',
        'brand',
        'tags',
        'suitable_for_species',
        'suitable_for_ages',
        'suitable_for_sizes',
        'primary_pillar',
        'pillar_benefits',
        'price',
        'original_price',
        'cost_price',
        'stock_quantity',
        'low_stock_threshold',
        'manage_stock',
        'weight',
        'dimensions',
        'status',
        'featured',
        'images',
        'videos',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'shipping_required',
        'shipping_weight',
        'shipping_dimensions',
        'rating',
        'review_count',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'tags' => 'array',
        'suitable_for_species' => 'array',
        'suitable_for_ages' => 'array',
        'suitable_for_sizes' => 'array',
        'pillar_benefits' => 'array',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'shipping_weight' => 'decimal:2',
        'rating' => 'decimal:2',
        'featured' => 'boolean',
        'manage_stock' => 'boolean',
        'shipping_required' => 'boolean',
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
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
            if (empty($model->sku)) {
                $model->sku = 'APWAP-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Relation avec les avis
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Relation avec les articles du panier
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relation avec les articles de commande
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope pour les produits actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pour les produits en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope pour les produits en stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Scope pour recherche par nom ou description
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%");
    }

    /**
     * Scope pour filtrer par catégorie
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope pour filtrer par espèce
     */
    public function scopeSuitableForSpecies($query, $species)
    {
        return $query->whereJsonContains('suitable_for_species', $species);
    }

    /**
     * Scope pour filtrer par pilier APWAP
     */
    public function scopeForPillar($query, $pillar)
    {
        return $query->where('primary_pillar', $pillar);
    }

    /**
     * Vérifier si le produit est en stock
     */
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Vérifier si le stock est faible
     */
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * Obtenir le prix avec réduction
     */
    public function getDiscountedPriceAttribute()
    {
        return $this->original_price ? $this->price : null;
    }

    /**
     * Vérifier si le produit a une réduction
     */
    public function hasDiscount()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Obtenir le pourcentage de réduction
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return 0;
        }
        
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    /**
     * Obtenir l'URL de l'image principale
     */
    public function getImageUrlAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            // Si l'image commence par http, c'est une URL complète
            if (str_starts_with($this->images[0], 'http')) {
                return $this->images[0];
            }
            // Si l'image commence par 'images/', c'est un chemin public
            if (str_starts_with($this->images[0], 'images/')) {
                return asset($this->images[0]);
            }
            // Sinon, construire l'URL relative pour storage
            return asset('storage/' . $this->images[0]);
        }
        return null;
    }

    /**
     * Obtenir l'image principale
     */
    public function getMainImageAttribute()
    {
        return $this->images && count($this->images) > 0 ? $this->images[0] : null;
    }

    /**
     * Calculer la note moyenne
     */
    public function updateRating()
    {
        $reviews = $this->reviews;
        if ($reviews->count() > 0) {
            $this->rating = $reviews->avg('rating');
            $this->review_count = $reviews->count();
            $this->save();
        }
    }

    /**
     * Recommandations basées sur l'animal
     */
    public static function getRecommendationsForPet($pet, $limit = 6)
    {
        return static::active()
            ->suitableForSpecies($pet->species)
            ->inStock()
            ->orderBy('rating', 'desc')
            ->orderBy('review_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Produits populaires
     */
    public static function getPopularProducts($limit = 8)
    {
        return static::active()
            ->inStock()
            ->orderBy('rating', 'desc')
            ->orderBy('review_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
