<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ShopTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        $this->user = User::factory()->create();
        
        // Create test category
        $this->category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test category description',
            'is_active' => true,
            'sort_order' => 1
        ]);
        
        // Create test product
        $this->product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'short_description' => 'Test product short description',
            'description' => 'Test product description',
            'price' => 29.99,
            'category_id' => $this->category->id,
            'sku' => 'TEST-001',
            'stock_quantity' => 10,
            'is_active' => true,
            'is_featured' => true,
            'animal_types' => ['chien', 'chat']
        ]);
    }

    public function test_shop_index_page_displays_correctly()
    {
        $response = $this->get(route('shop.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Boutique Premium APWAP');
        $response->assertSee($this->product->name);
        $response->assertSee($this->category->name);
    }

    public function test_product_page_displays_correctly()
    {
        $response = $this->get(route('shop.product', $this->product->slug));
        
        $response->assertStatus(200);
        $response->assertSee($this->product->name);
        $response->assertSee($this->product->description);
        $response->assertSee(number_format($this->product->price, 2));
    }

    public function test_category_page_displays_correctly()
    {
        $response = $this->get(route('shop.category', $this->category->slug));
        
        $response->assertStatus(200);
        $response->assertSee($this->category->name);
        $response->assertSee($this->product->name);
    }

    public function test_authenticated_user_can_add_product_to_cart()
    {
        $this->actingAs($this->user);
        
        $response = $this->postJson('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'cart_count'
        ]);
        
        // Verify cart was created and item added
        $cart = Cart::where('user_id', $this->user->id)->first();
        $this->assertNotNull($cart);
        $this->assertEquals(1, $cart->items->count());
        $this->assertEquals(2, $cart->items->first()->quantity);
        $this->assertEquals($this->product->id, $cart->items->first()->product_id);
    }

    public function test_cart_page_displays_correctly_for_authenticated_user()
    {
        $this->actingAs($this->user);
        
        // Add product to cart first
        $cart = Cart::create(['user_id' => $this->user->id]);
        $cart->items()->create([
            'product_id' => $this->product->id,
            'quantity' => 1,
            'unit_price' => $this->product->price,
            'total_price' => $this->product->price
        ]);
        
        $response = $this->get(route('cart.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Mon panier');
        $response->assertSee($this->product->name);
    }

    public function test_guest_user_cannot_add_to_cart()
    {
        $response = $this->postJson('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 1
        ]);
        
        $response->assertStatus(401);
    }

    public function test_search_functionality_works()
    {
        $response = $this->get(route('shop.search', ['q' => 'Test']));
        
        $response->assertStatus(200);
        $response->assertSee('Résultats de recherche');
        $response->assertSee($this->product->name);
    }

    public function test_search_with_no_results()
    {
        $response = $this->get(route('shop.search', ['q' => 'NonExistentProduct']));
        
        $response->assertStatus(200);
        $response->assertSee('Aucun résultat trouvé');
    }

    public function test_cart_count_api_endpoint()
    {
        $this->actingAs($this->user);
        
        // Create cart with items
        $cart = Cart::create(['user_id' => $this->user->id]);
        $cart->items()->create([
            'product_id' => $this->product->id,
            'quantity' => 3,
            'unit_price' => $this->product->price,
            'total_price' => $this->product->price * 3
        ]);
        
        $response = $this->getJson('/cart/count');
        
        $response->assertStatus(200);
        $response->assertJson(['count' => 3]);
    }

    public function test_product_recommendations_work()
    {
        $this->actingAs($this->user);
        
        // Create additional products for recommendations
        $relatedProduct = Product::create([
            'name' => 'Related Product',
            'slug' => 'related-product',
            'short_description' => 'Related product description',
            'description' => 'Related product long description',
            'price' => 19.99,
            'category_id' => $this->category->id,
            'sku' => 'REL-001',
            'stock_quantity' => 5,
            'is_active' => true,
            'animal_types' => ['chien']
        ]);
        
        $response = $this->get(route('shop.product', $this->product->slug));
        
        $response->assertStatus(200);
        $response->assertSee('Produits similaires');
    }

    public function test_featured_products_display_on_homepage()
    {
        $response = $this->get(route('shop.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Produits en vedette');
        $response->assertSee($this->product->name); // Should show as it's featured
    }

    public function test_categories_display_on_homepage()
    {
        $response = $this->get(route('shop.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Catégories');
        $response->assertSee($this->category->name);
    }

    public function test_out_of_stock_product_cannot_be_added_to_cart()
    {
        $this->actingAs($this->user);
        
        // Set product out of stock
        $this->product->update(['stock_quantity' => 0]);
        
        $response = $this->postJson('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 1
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quantity']);
    }

    public function test_cannot_add_more_than_available_stock()
    {
        $this->actingAs($this->user);
        
        $response = $this->postJson('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 15 // More than available stock (10)
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quantity']);
    }
}
