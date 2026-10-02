<?php

it('can switch the locale to arabic', function (): void {
    $response = $this
        ->withSession(['locale' => 'en'])
        ->post(route('locale.update', ['locale' => 'ar']));

    $response
        ->assertRedirect()
        ->assertSessionHas('locale', 'ar');
});

it('can switch the locale to english', function (): void {
    $response = $this
        ->withSession(['locale' => 'ar'])
        ->post(route('locale.update', ['locale' => 'en']));

    $response
        ->assertRedirect()
        ->assertSessionHas('locale', 'en');
});

it('rejects unsupported locales', function (): void {
    $response = $this->post(
        route('locale.update', ['locale' => 'fr'])
    );

    $response->assertStatus(400);
});
