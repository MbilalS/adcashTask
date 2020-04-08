<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Category;

class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIndexCategories()
    {
        $categories = factory(Category::class, 5)->make();
        Category::insert($categories->toArray());

        $response = $this->get('api/categories');

        $response->assertStatus(200);

        $response->assertJson([
            'categories' => $response->decodeResponseJson()['categories'],
            'success' => true,
            'message' => 'Categories retrieved successfully'
        ]);
    }

    public function testStoreCategories()
    {
        $response = $this->postJson('api/categories', ['category_name' => 'category1']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'category_name' => 'category1',
                'success' => true,
                'message' => 'Category created successfully'
            ]);
    }

    public function testUpdateCategories()
    {
        $category = factory(Category::class)->make();
        $category->save();

        $response = $this->putJson('api/categories', ['category' => ['id' => $category['id'], 'name' => 'category2']]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'category' => $response->decodeResponseJson()['category'],
                'success' => true,
                'message' => 'Category updated successfully'
            ]);
    }

    public function testDestoryCategories()
    {
        $category = factory(Category::class)->make();
        $category->save();

        $response = $this->deleteJson('api/categories/'.$category['id']);
        $response->assertStatus(200);

        $response = $this->get('api/categories');

        $response
            ->assertStatus(200)
            ->assertJson([
                'categories' => $response->decodeResponseJson()['categories'],
                'success' => true,
                'message' => 'Categories retrieved successfully'
            ]);
    }
}
