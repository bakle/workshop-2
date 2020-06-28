<?php

namespace Tests\Feature\User;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StoreTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function aNotAuthenticatedCannotStoreAUser()
    {
        $response = $this->get(route('users.store'));

        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function aAuthenticatedCanStoreAUser()
    {
        // Arrange
        $user = factory(User::class)->create();

        // Act
        $response = $this->actingAs($user)
            ->post(route('users.store'), [
                'first_name' => 'Jhon',
                'last_name' => 'Doe',
                'email' => 'jhon@mail.com',
                'password' => 'admin',
            ]);

        //Assert
        $userA = User::orderBy('id', 'desc')->first();

        $this->assertEquals('Jhon', $userA->first_name);
        $this->assertEquals('Doe', $userA->last_name);
        $this->assertEquals('jhon@mail.com', $userA->email);
        $this->assertTrue(Hash::check('admin', $userA->password));
        $this->assertTrue(Cache::has('user.' . $userA->id));
        $response->assertRedirect(route('users.index'));

    }
}
