<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_only_active_posts()
    {
        $active = Post::factory()->create([
            'is_draft' => false,
            'published_at' => now()->subDay(),
        ]);

        $draft = Post::factory()->create([
            'is_draft' => true,
        ]);

        $scheduled = Post::factory()->create([
            'is_draft' => true,
            'published_at' => now()->addDay(),
        ]);

        $response = $this->get('/posts');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $active->id])
            ->assertJsonMissing(['id' => $draft->id])
            ->assertJsonMissing(['id' => $scheduled->id]);
    }

    #[Test]
    public function it_returns_404_if_post_is_draft_or_scheduled()
    {
        $draft = Post::factory()->create(['is_draft' => true]);

        $this->get("/posts/{$draft->id}")
            ->assertStatus(404);
    }

    #[Test]
    public function authenticated_user_can_create_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $payload = [
            'title' => 'New Post',
            'content' => 'Content here',
            'is_draft' => false,
            'published_at' => now()->toDateTimeString(),
        ];

        $response = $this->post('/posts', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New Post']);
    }

    #[Test]
    public function only_author_can_update_post()
    {
        $author = User::factory()->create();
        $other = User::factory()->create();

        $post = Post::factory()->create(['user_id' => $author->id]);

        $this->actingAs($other);

        $this->put("/posts/{$post->id}", [
            'title' => 'Updated',
        ])->assertStatus(403);
    }

    #[Test]
    public function only_author_can_delete_post()
    {
        $author = User::factory()->create();
        $other = User::factory()->create();

        $post = Post::factory()->create(['user_id' => $author->id]);

        $this->actingAs($other);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(403);
    }
}
