<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_author()
    {
        $response = $this->postJson('/api/authors', [
            'name' => 'J.K. Rowling',
            'bio' => 'British author',
            'birth_date' => '1965-07-31',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'J.K. Rowling',
                'bio' => 'British author',
            ]);

        $this->assertDatabaseHas('authors', [
            'name' => 'J.K. Rowling',
        ]);
    }

    /** @test */
    public function it_can_retrieve_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $author->id,
                'name' => $author->name,
            ]);
    }

    /** @test */
    public function it_can_update_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", [
            'name' => 'Updated Name',
            'bio' => 'Updated bio',
            'birth_date' => '1965-07-31',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Name',
            ]);

        $this->assertDatabaseHas('authors', [
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function it_can_delete_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', [
            'id' => $author->id,
        ]);
    }

    /** @test */
    public function it_returns_404_for_nonexistent_author()
    {
        $response = $this->getJson('/api/authors/999');

        $response->assertStatus(404);
    }
}
