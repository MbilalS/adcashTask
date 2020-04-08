<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIndexProducts()
    {
        $products = factory(Product::class, 5)->make();
        Product::insert($products->toArray());

        $response = $this->get('api/products');

        $response->assertStatus(200);

        $response->assertJson([
            'products' => $response->decodeResponseJson()['products'],
            'success' => true,
            'message' => 'Products retrieved successfully'
        ]);
    }

    public function testConcreteCategoryProducts()
    {
        $products = factory(Product::class, 5)->make();
        Product::insert($products->toArray());

        $response = $this->get('api/categories');
        $category_name = $response->decodeResponseJson()['categories'][0]['name'];

        $response = $this->get('api/products/concrete-category?category_name='.$category_name);

        $response->assertStatus(200);

        $response->assertJson([
            'products' => $response->decodeResponseJson()['products'],
            'success' => true,
            'message' => 'Products retrieved successfully'
        ]);
    }

    public function testStoreProductes()
    {
        $response = $this->postJson('api/products', ['product_name' => 'product1']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'product_name' => 'product1',
                'success' => true,
                'message' => 'Product created successfully'
            ]);
    }

    public function testUpdateProductes()
    {
        $product = factory(Product::class)->make();
        $product->save();

        $response = $this->putJson('api/products', ['product' => ['id' => $product['id'], 'name' => 'product2']]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'product' => $response->decodeResponseJson()['product'],
                'success' => true,
                'message' => 'Product updated successfully'
            ]);
    }

    public function testDestoryProductes()
    {
        $product = factory(Product::class)->make();
        $product->save();

        $response = $this->deleteJson('api/products/'.$product['id']);
        $response->assertStatus(200);

        $response = $this->get('api/products');

        $response
            ->assertStatus(200)
            ->assertJson([
                'products' => $response->decodeResponseJson()['products'],
                'success' => true,
                'message' => 'Products retrieved successfully'
            ]);
    }
}
