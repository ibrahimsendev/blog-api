<?php

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot create comment', function () {
    $response = $this->postJson('/api/comments', [
        'post_id' => 1,
        'content' => 'Test comment',
    ]);

    $response->assertStatus(401);
});

test('authenticated user can create comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/comments', [
        'post_id' => $post->id,
        'content' => 'This is a test comment',
    ]);

    $response->assertStatus(201);
    $response->assertJson([
        'data' => [
            'content' => 'This is a test comment',
            'post_id' => $post->id,
        ]
    ]);
});

test('authenticated user can update own comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->putJson("/api/comments/{$comment->id}", [
        'content' => 'Updated comment content',
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'content' => 'Updated comment content',
        ]
    ]);
});

test('user cannot update others comment', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'user_id' => $otherUser->id,
        'post_id' => $post->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->putJson("/api/comments/{$comment->id}", [
        'content' => 'Hacking attempt',
    ]);

    $response->assertStatus(403);
});

test('authenticated user can delete own comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/comments/{$comment->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('comments', [
        'id' => $comment->id,
    ]);
});

test('user cannot delete others comment', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'user_id' => $otherUser->id,
        'post_id' => $post->id,
    ]);

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/comments/{$comment->id}");

    $response->assertStatus(403);
});
