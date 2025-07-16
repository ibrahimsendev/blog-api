<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot create category', function () {
    $response = $this->postJson('/api/categories', [
        'name' => 'Test Category',
    ]);

    $response->assertStatus(401);
});

test('authenticated user can create category', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/categories', [
        'name' => 'Sample Category',
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('categories', ['name' => 'Sample Category']);
});

test('authenticated user can update category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Old Name']);

    $response = $this->actingAs($user, 'sanctum')->putJson('/api/categories/' . $category->id, [
        'name' => 'Updated Name',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('categories', ['name' => 'Updated Name']);
});

test('authenticated user can delete category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->deleteJson('/api/categories/' . $category->id);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('user can list categories', function () {
    Category::factory()->count(3)->create();

    $response = $this->getJson('/api/categories');

    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
});
