<?php

use App\Models\Post;
use App\Models\User;

test('Post listing page should render', function () {
    $response = $this->get(route('post.index'));

    $response->assertStatus(200);
});

test('New post can not be added without user authentication', function () {

    $response = $this->post(route('post.store'), [
        'title' => 'Test title',
        'content' => 'test content',
    ]);

    $response->assertRedirect(route('login'));
});

test('Authenticated user can create post', function () {

    $user = User::factory()->create();
    $this->actingAs($user)->post(route('post.store'), [
        'title' => 'Test title',
        'content' => 'test content',
    ])->assertRedirect(route('post.index'));

    $this->assertDatabaseHas('posts', ['title' => 'Test title']);
});

test('user can view post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $this->get(route('post.show', ['post' => $post->slug]))->assertStatus(200);
});

test('User who does not own post cant view edit post page', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user2)->get(route('post.edit', ['post' => $post->slug]))->assertStatus(403);
});

test('User who does own post can view edit post page', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->get(route('post.edit', ['post' => $post->slug]))->assertStatus(200);
});

test('User can update post who owns it', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->patch(route('post.update', ['post' => $post->slug]), [
        'title' => 'Test title',
        'content' => 'test content',
    ])->assertRedirect(route('post.index'));

    $this->assertDatabaseHas('posts', ['title' => 'Test title']);
});

test('Post should get deleted with authorized user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->delete(route('post.destroy', ['post' => $post->slug]))->assertRedirect(route('post.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});
