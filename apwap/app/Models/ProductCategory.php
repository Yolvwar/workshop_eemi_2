<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
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

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image_url',
        'icon',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
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
        });
    }

    /**
     * Relation avec le parent
     */
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Relation avec les enfants
     */
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Relation avec les produits
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Scope pour les catégories actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les catégories principales (sans parent)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Obtenir toutes les catégories principales avec leurs enfants
     */
    public static function getMainWithChildren()
    {
        return static::active()
            ->main()
            ->with(['children' => function($query) {
                $query->active()->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Obtenir le chemin complet de la catégorie
     */
    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }

    /**
     * Vérifier si c'est une catégorie principale
     */
    public function isMainCategory()
    {
        return is_null($this->parent_id);
    }

    /**
     * Compter les produits actifs
     */
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->active()->count();
    }
}
