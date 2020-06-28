<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aNotAuthenticatedCannotListUsers()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function anAuthenticatedUserCanListUsers()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertOk();
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');

        $responseUsers = $response->getOriginalContent()['users'];

        $responseUsers->each(function($item) use ($user) {
            $this->assertEquals($user->id, $item->id);
        });
    }
}
