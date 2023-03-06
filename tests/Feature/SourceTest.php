<?php

namespace Tests\Feature;

use App\Models\Source;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SourceTest extends TestCase
{
    public function test_sources_can_be_retrieved()
    {
        list($user) = $this->getTestData();
        $this->authenticate($user);
        Source::factory()->create([
            'name' => 'New York Times'
        ]);
        $this->get('api/v1/sources')
            ->assertStatus(200)
            ->assertJson(
                fn(AssertableJson $json) => $json->has('links')
                    ->has('meta')
                    ->has('data', 1)
                    ->has(
                        'data.0',
                        fn($json) => $json->where('name', 'New York Times')
                            ->etc()
                    )
            );
    }
}
