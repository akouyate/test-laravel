<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->artisan('migrate');
});

it('fails to create a new task with missing text', function () {
    $data = [
        'tasks' => ['call_reason', 'call_actions'],
    ];

    $response = $this->postJson('/api/tasks', $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['text']);
});

it('fails to create a new task with missing tasks', function () {
    $data = [
        'text' => 'Sample Task',
    ];

    $response = $this->postJson('/api/tasks', $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['tasks']);
});

it('fails to create a new task with invalid tasks data', function () {
    $data = [
        'text' => 'Sample Task',
        'tasks' => ['invalid_task_type'],
    ];

    $response = $this->postJson('/api/tasks', $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['tasks.0']);
});


it('creates a new task with valid data', function () {
    $data = [
        'text' => 'Sample Task',
        'tasks' => ['call_reason', 'call_actions'],
    ];

    $response = $this->postJson('/api/tasks', $data);

    $response->assertStatus(Response::HTTP_CREATED);

    // Extract the UUID from the response
    $responseData = $response->json();
    $jobId = $responseData['id'];

    // Assert the job was actually created in the database
    $this->assertDatabaseHas('jobs', ['uuid' => $jobId]);
});
