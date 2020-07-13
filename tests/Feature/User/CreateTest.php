<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function aNotAuthenticatedUserCannotViewTheCreateForm()
    {
        $response = $this->get(route('users.create'));

        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function anAuthenticatedUserCanViewTheCreateForm()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('users.create'));

        $response->assertOk();
        $response->assertViewIs('users.create');
        $response->assertSeeText('Create User');
        $response->assertSeeText('First Name');
        $response->assertSeeText('Last Name');
        $response->assertSeeText('Email');
        $response->assertSeeText('Password');
        $response->assertSeeText('Create');

    }
}
