<?php

use App\Models\Task;
use App\Models\User;

test('task listing page should not open without authentication', function () {
    $response = $this->get(route('task.index'));

    $response->assertStatus(302);
});

test('New task can not be added without user authentication', function () {

    $response = $this->post(route('task.store'), [
        'title' => 'Test title',
        'description' => 'test description',
        'status' => 'pending',
        'due_date' => '2023-10-19',
    ]);

    $response->assertRedirect(route('login'));
});

test('Authenticated user can create task', function () {

    $user = User::factory()->create();
    $this->actingAs($user)->post(route('task.store'), [
        'title' => 'Test title',
        'description' => 'test description',
        'status' => 'pending',
        'due_date' => '2023-10-19',
    ])->assertRedirect(route('task.index'));

    $this->assertDatabaseHas('tasks', ['title' => 'Test title']);
});

test('guest user can not view task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->get(route('task.show', ['task' => $task->id]))->assertStatus(302);
});

test('authenticated but not authorized user can not view task', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user2)->get(route('task.show', ['task' => $task->id]))->assertStatus(403);
});

test('authenticated and authorized user can view task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->get(route('task.show', ['task' => $task->id]))->assertStatus(200);
});

test('User who does not own task cant view edit task page', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user2)->get(route('task.edit', ['task' => $task->id]))->assertStatus(403);
});

test('User who does own task can view edit task page', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->get(route('task.edit', ['task' => $task->id]))->assertStatus(200);
});

test('User can update task who owns it', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->patch(route('task.update', ['task' => $task->id]), [
        'title' => 'Test title',
        'description' => 'test description',
        'status' => 'pending',
        'due_date' => '2023-10-19',
    ])->assertRedirect(route('task.index'));

    $this->assertDatabaseHas('tasks', ['title' => 'Test title']);
});

test('task should get deleted with authorized user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->delete(route('task.destroy', ['task' => $task->id]))->assertRedirect(route('task.index'));

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});
