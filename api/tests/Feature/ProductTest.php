<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Product;

class ProductTest extends TestCase
{
    // Run migrations before and clear database after each test
    use RefreshDatabase;

    /**
     * Ensure Product returned from end includes data
     *
     * @return void
     */
    public function testProductResponse()
    {
        // Create product in database
        $productData = [
            'title' => 'Test Product Title',
            'description' => 'Test Product Description',
            'price' => 7.49,
            'availability' => true,
        ];
        $productModel = Product::create($productData);

        // Test response from our /products/:id endpoint to ensure it at least returns the data included above
        // (doesn't throw if we get more than this)
        $this->get("/products/{$productModel->id}")
            ->assertStatus(200)
            ->assertJson([
                'data' => $productData
            ]);

        // Remove product from database
        $productModel->delete();
    }
}
