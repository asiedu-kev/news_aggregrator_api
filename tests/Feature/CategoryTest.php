<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_categories_can_be_retrieved()
    {
        list($user) = $this->getTestData();
        $this->authenticate($user);
        Category::factory()->create([
            'name' => 'Test Category'
        ]);
        $this->get('api/v1/categories')
            ->assertStatus(200)
            ->assertJson(
                fn(AssertableJson $json) => $json->has('links')
                    ->has('meta')
                    ->has('data', 1)
                    ->has(
                        'data.0',
                        fn($json) => $json->where('name', 'Test Category')
                            ->etc()
                    )
            );
    }
}
