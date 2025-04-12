<?php

use App\Models\User;
use App\Models\Category as CategoryModel;
use App\Livewire\Category;
use Livewire\Livewire;

test('guests are redirected to the login page', function () {
    $this->get('/categories')->assertRedirect('/login');
});

test('authenticated users can visit the categories', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/categories')->assertStatus(200);
});

test('new categories can save', function () {
    $this->actingAs($user = User::factory()->create());

    $response = Livewire::test(Category::class)
        ->call('formOpen')
        ->set('name', 'Categoría')
        ->set('description', 'Descripción categoría')
        ->call('save');

    $response->assertHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'Categoría',
        'description' => 'Descripción categoría',
    ]);
});

test('the categories can update', function () {
    $this->actingAs($user = User::factory()->create());

    $category = CategoryModel::factory()->create([
        'name' => 'Categoría',
        'description' => 'Descripción categoría',
    ]);

    $response = Livewire::test(Category::class)
        ->call('formOpen', $category->id)
        ->set('name', 'Categoría 2')
        ->set('description', 'Descripción categoría 2')
        ->call('save');

    $response->assertHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'Categoría 2',
        'description' => 'Descripción categoría 2',
    ]);
    $this->assertDatabaseMissing('categories', [
        'name' => 'Categoría',
        'description' => 'Descripción categoría',
    ]);
});

test('the categories can delete', function () {
    $this->actingAs($user = User::factory()->create());

    $category = CategoryModel::factory()->create([
        'name' => 'Categoría',
        'description' => 'Descripción categoría',
    ]);

    Livewire::test(Category::class)
        ->call('selectId', $category->id)
        ->call('deleteRecord');

    $this->assertDatabaseMissing('categories', [
        'name' => 'Categoría',
        'description' => 'Descripción categoría',
    ]);
});