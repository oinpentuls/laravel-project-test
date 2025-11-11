<?php

use App\Mail\NewUserNotificationMail;
use App\Mail\SendConfirmationUserCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

pest()->use(RefreshDatabase::class);

test('create user without authentication', function () {
    $this->actingAsGuest();

    $response = $this->postJson('/api/users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(401);
});

test('create user', function () {
    $admin = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
    ]);

    $response = $this->actingAs($admin)
        ->postJson('/api/users', [
            'name' => 'User 1',
            'email' => 'user1@mail.com',
            'password' => bcrypt('password'),
        ]);

    $response->assertStatus(200);
});

test('create user with invalid data', function () {
    $admin = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
    ]);

    $response = $this->actingAs($admin)
        ->postJson('/api/users', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

    $response->assertStatus(422);
});

test('get users without authentication', function () {
    $this->actingAsGuest();

    $response = $this->getJson('/api/users');

    $response->assertStatus(401);
});


test('get users', function () {
    $admin = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
    ]);

    $response = $this->actingAs($admin)
        ->getJson('/api/users');

    $response->assertStatus(200);
});

test('get users with query search', function () {
    $admin = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
    ]);

    User::factory()->create([
        'name' => 'User 1',
        'email' => 'user1@mail.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($admin)
        ->getJson('/api/users?search=user1@mail.com');

    $response->assertJsonPath('data.0.name', 'User 1');
    $response->assertStatus(200);
});

test('get users with query sort by', function () {
    $admin = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
    ]);

    User::factory()->createMany([
        [
            'name' => 'User 1',
            'email' => 'user1@mail.com',
            'password' => bcrypt('password'),
        ],
        [
            'name' => 'User 2',
            'email' => 'user2@mail.com',
            'password' => bcrypt('password'),
        ],
    ]);

    $response = $this->actingAs($admin)
        ->getJson('/api/users?sortBy=name');

    $response->dump();
    $response->assertJsonPath('data.0.name', 'Administrator');
    $response->assertStatus(200);
});

test('Send email to the user and admin', function () {
    Mail::fake();

    $admin = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
    ]);

    $response = $this->actingAs($admin)
        ->postJson('/api/users', [
            'name' => 'User 1',
            'email' => 'user1@mail.com',
            'password' => bcrypt('password'),
        ]);

    Mail::assertSent(SendConfirmationUserCreated::class);
    Mail::assertSent(NewUserNotificationMail::class);
    $response->assertStatus(200);
});
