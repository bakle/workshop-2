<?php

namespace Tests\Feature\User;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class StoreTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function aNotAuthenticatedCannotStoreAUser()
    {
        $this->get(route('users.store'))->assertRedirect('login');
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

    /**
     * @test
     * @dataProvider usersDataProvider
     * @param string $field
     * @param string|null $value
     */
    public function itCannotSaveUserWhenDataIsIncorrect(string $field, ? string $value)
    {
        // Arrange
        $user = factory(User::class)->create();
        $data = [
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'jhon',
            'password' => 'admin',
        ];
        $data[$field] = $value;

        // Act
        $response = $this->actingAs($user)
            ->post(route('users.store'), $data);

        // Assert
        $response->assertRedirect();
        $response->assertSessionHasErrors($field);
    }

    public function usersDataProvider(): array
    {
        return [
            'Test first name is required' => ['first_name', null],
            'Test first name is too short' => ['first_name', 'j'],
            'Test first name is too long' => ['first_name', Str::random(81)],
            'Test last name is required' => ['last_name', null],
            'Test last name is too long' => ['last_name', Str::random(81)],
            'Test email is required' => ['email', null],
            'Test email is not an email' => ['email', 'john.ortiz'],
            'Test password is required' => ['password', null],
            'Test password is too short' => ['password', 'asd'],
            'Test password is too long' => ['password', Str::random(81)],
        ];
    }
}
