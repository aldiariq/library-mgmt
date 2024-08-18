<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_book()
    {
        $author = Author::factory()->create();

        $response = $this->postJson('/api/books', [
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'description' => 'A fantasy novel',
            'publish_date' => '1997-06-26',
            'author_id' => $author->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author_id' => $author->id,
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Harry Potter and the Philosopher\'s Stone',
        ]);
    }

    /** @test */
    public function it_can_retrieve_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $book->id,
                'title' => $book->title,
            ]);
    }

    /** @test */
    public function it_can_update_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'publish_date' => '2000-01-01',
            'author_id' => $book->author_id,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Updated Title',
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }

    /** @test */
    public function it_returns_404_for_nonexistent_book()
    {
        $response = $this->getJson('/api/books/999');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_retrieve_books_by_author()
    {
        $author = Author::factory()->create();
        $book1 = Book::factory()->create(['author_id' => $author->id]);
        $book2 = Book::factory()->create(['author_id' => $author->id]);

        $response = $this->getJson("/api/authors/{$author->id}/books");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $book1->id,
                'title' => $book1->title,
            ])
            ->assertJsonFragment([
                'id' => $book2->id,
                'title' => $book2->title,
            ]);
    }
}
