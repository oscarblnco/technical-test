<?php

use App\Models\User;
use App\Models\Book as BookModel;
use App\Livewire\Book;
use Livewire\Livewire;

test('guests are redirected to the login page', function () {
    $this->get('/books')->assertRedirect('/login');
});

test('authenticated users can visit the books', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/books')->assertStatus(200);
});

test('new books can save', function () {
    $this->actingAs($user = User::factory()->create());

    $response = Livewire::test(Book::class)
        ->call('formOpen')
        ->set('title', 'mi titulo de libro')
        ->set('author', 'autor del libro')
        ->set('editorial', 'editorial del libro')
        ->set('yearPublication', 2005)
        ->call('save');

    $response->assertHasNoErrors();

    $this->assertDatabaseHas('books', [
        'title' => 'mi titulo de libro',
        'author' => 'autor del libro',
        'editorial' => 'editorial del libro',
        'year_publication' => 2005,
    ]);
});

test('the book can update', function () {
    $this->actingAs($user = User::factory()->create());

    $Book = BookModel::factory()->create([
        'title' => 'mi titulo de libro',
        'author' => 'autor del libro',
        'editorial' => 'editorial del libro',
        'year_publication' => '2005',
    ]);

    $response = Livewire::test(Book::class)
        ->call('formOpen', $Book->id)
        ->set('title', 'mi titulo editado de libro')
        ->set('author', 'autor del libro editado')
        ->set('editorial', 'editorial del libro editado')
        ->set('yearPublication', '2020')
        ->call('save');

    $response->assertHasNoErrors();

    $this->assertDatabaseHas('books', [
        'title' => 'mi titulo editado de libro',
        'author' => 'autor del libro editado',
        'editorial' => 'editorial del libro editado',
        'year_publication' => 2020
    ]);
    $this->assertDatabaseMissing('books', [
        'title' => 'mi titulo de libro',
        'author' => 'autor del libro',
        'editorial' => 'editorial del libro',
        'year_publication' => 2005
    ]);
});

test('the books can delete', function () {
    $this->actingAs($user = User::factory()->create());

    $Book = BookModel::factory()->create([
        'title' => 'mi titulo de libro',
        'author' => 'autor del libro',
        'editorial' => 'editorial del libro',
        'year_publication' => '2005',
    ]);

    Livewire::test(Book::class)
        ->call('selectId', $Book->id)
        ->call('deleteRecord');

    $this->assertDatabaseMissing('books', [
        'title' => 'mi titulo de libro',
        'author' => 'autor del libro',
        'editorial' => 'editorial del libro',
        'year_publication' => '2005',
    ]);
});