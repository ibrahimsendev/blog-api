<?php

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot create post', function () {
    $response = $this->postJson('/api/posts', [
        'title' => 'Unauthorized Post',
        'content' => 'Unauthorized content',
    ]);

    $response->assertStatus(401);
});

test('authenticated user can create post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/posts', [
        'title' => 'Sample Post Title',
        'content' => 'Sample post content.',
        'category_id' => $category->id,
    ]);

    $response->assertStatus(201);
    $response->assertJsonFragment([
        'title' => 'Sample Post Title',
    ]);
});

test('authenticated user can update own post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->putJson("/api/posts/{$post->id}", [
        'title' => 'Updated Post Title',
        'content' => 'Updated post content.',
    ]);

    $response->assertStatus(200);

    $response->assertJsonPath('data.title', 'Updated Post Title');
    $response->assertJsonPath('data.content', 'Updated post content.');
});

test('authenticated user can delete own post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/posts/{$post->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
});

test('user cannot update others post', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->putJson("/api/posts/{$post->id}", [
        'title' => 'Hacked Title',
        'content' => 'Hacked Content',
    ]);

    $response->assertStatus(403);
});

test('user cannot delete others post', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/posts/{$post->id}");

    $response->assertStatus(403);
});
