<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pet;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_has_category_relationship()
    {
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'TEST-001',
            'stock_quantity' => 10,
            'is_active' => true
        ]);

        $this->assertInstanceOf(ProductCategory::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_category_has_products_relationship()
    {
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'TEST-001',
            'stock_quantity' => 10,
            'is_active' => true
        ]);

        $this->assertTrue($category->products->contains($product));
        $this->assertEquals(1, $category->products->count());
    }

    public function test_user_has_cart_relationship()
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(Cart::class, $user->cart);
        $this->assertEquals($cart->id, $user->cart->id);
    }

    public function test_cart_calculates_total_correctly()
    {
        $user = User::factory()->create();
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $product1 = Product::create([
            'name' => 'Product 1',
            'slug' => 'product-1',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 20.00,
            'category_id' => $category->id,
            'sku' => 'PROD-001',
            'stock_quantity' => 10,
            'is_active' => true
        ]);

        $product2 = Product::create([
            'name' => 'Product 2',
            'slug' => 'product-2',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 15.00,
            'category_id' => $category->id,
            'sku' => 'PROD-002',
            'stock_quantity' => 10,
            'is_active' => true
        ]);

        $cart = Cart::create(['user_id' => $user->id]);

        $cart->items()->create([
            'product_id' => $product1->id,
            'quantity' => 2,
            'unit_price' => $product1->price,
            'total_price' => $product1->price * 2
        ]);

        $cart->items()->create([
            'product_id' => $product2->id,
            'quantity' => 1,
            'unit_price' => $product2->price,
            'total_price' => $product2->price * 1
        ]);

        // Refresh cart to calculate totals
        $cart->refresh();
        $cart->calculateTotals();

        $this->assertEquals(55.00, $cart->total_amount); // (20 * 2) + (15 * 1) = 55
    }

    public function test_product_is_in_stock_scope()
    {
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $inStockProduct = Product::create([
            'name' => 'In Stock Product',
            'slug' => 'in-stock-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'IN-001',
            'stock_quantity' => 5,
            'is_active' => true
        ]);

        $outOfStockProduct = Product::create([
            'name' => 'Out of Stock Product',
            'slug' => 'out-of-stock-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'OUT-001',
            'stock_quantity' => 0,
            'is_active' => true
        ]);

        $inStockProducts = Product::inStock()->get();

        $this->assertTrue($inStockProducts->contains($inStockProduct));
        $this->assertFalse($inStockProducts->contains($outOfStockProduct));
    }

    public function test_product_featured_scope()
    {
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $featuredProduct = Product::create([
            'name' => 'Featured Product',
            'slug' => 'featured-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'FEAT-001',
            'stock_quantity' => 5,
            'is_active' => true,
            'is_featured' => true
        ]);

        $regularProduct = Product::create([
            'name' => 'Regular Product',
            'slug' => 'regular-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'REG-001',
            'stock_quantity' => 5,
            'is_active' => true,
            'is_featured' => false
        ]);

        $featuredProducts = Product::featured()->get();

        $this->assertTrue($featuredProducts->contains($featuredProduct));
        $this->assertFalse($featuredProducts->contains($regularProduct));
    }

    public function test_product_by_animal_type_scope()
    {
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $dogProduct = Product::create([
            'name' => 'Dog Product',
            'slug' => 'dog-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'DOG-001',
            'stock_quantity' => 5,
            'is_active' => true,
            'animal_types' => ['chien']
        ]);

        $catProduct = Product::create([
            'name' => 'Cat Product',
            'slug' => 'cat-product',
            'short_description' => 'Test description',
            'description' => 'Long description',
            'price' => 29.99,
            'category_id' => $category->id,
            'sku' => 'CAT-001',
            'stock_quantity' => 5,
            'is_active' => true,
            'animal_types' => ['chat']
        ]);

        $dogProducts = Product::byAnimalType('chien')->get();
        $catProducts = Product::byAnimalType('chat')->get();

        $this->assertTrue($dogProducts->contains($dogProduct));
        $this->assertFalse($dogProducts->contains($catProduct));
        $this->assertTrue($catProducts->contains($catProduct));
        $this->assertFalse($catProducts->contains($dogProduct));
    }

    public function test_user_orders_relationship()
    {
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => 50.00,
            'total' => 55.00,
            'shipping_cost' => 5.00,
            'shipping_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address' => '123 Test St',
                'city' => 'Test City',
                'postal_code' => '12345',
                'country' => 'FR'
            ]
        ]);

        $this->assertTrue($user->orders->contains($order));
        $this->assertEquals(1, $user->orders->count());
    }

    public function test_order_can_be_cancelled()
    {
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => 50.00,
            'total' => 55.00,
            'shipping_cost' => 5.00,
            'shipping_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address' => '123 Test St',
                'city' => 'Test City',
                'postal_code' => '12345',
                'country' => 'FR'
            ]
        ]);

        // Can cancel pending order
        $this->assertTrue($order->canCancel());

        // Cannot cancel shipped order
        $order->status = 'shipped';
        $this->assertFalse($order->canCancel());

        // Cannot cancel delivered order
        $order->status = 'delivered';
        $this->assertFalse($order->canCancel());
    }

    public function test_pet_belongs_to_user()
    {
        $user = User::factory()->create();

        $pet = Pet::create([
            'user_id' => $user->id,
            'name' => 'Buddy',
            'species' => 'chien',
            'breed' => 'Golden Retriever',
            'birth_date' => '2020-01-01',
            'gender' => 'male',
            'weight' => 25.5,
            'is_active' => true
        ]);

        $this->assertInstanceOf(User::class, $pet->user);
        $this->assertEquals($user->id, $pet->user->id);
        $this->assertTrue($user->pets->contains($pet));
    }
}
