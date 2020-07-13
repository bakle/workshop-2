<?php

namespace Tests\Feature\User;

use App\Country;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aNotAuthenticatedCannotUpdateAUser()
    {
        $user = factory(User::class)->create();
        $this->put(route('users.update', $user))->assertRedirect('login');
    }

    /**
     * @test
     */
    public function aAuthenticatedCanUpdateAUser()
    {
        // Arrange
        $user = factory(User::class)->create();
        $userA = factory(User::class)->create();
        $country = factory(Country::class)->create();


        // Act
        $response = $this->actingAs($user)
            ->put(route('users.update', $userA), [
                'first_name' => 'Jhon',
                'last_name' => 'Doe',
                'email' => 'jhon@mail.com',
                'password' => 'admin123456',
                'password_confirmation' => 'admin123456',
                'country' => $country->id,
            ]);

        // Assert
        $userA = $userA->refresh();

        $this->assertEquals('Jhon', $userA->first_name);
        $this->assertEquals('Doe', $userA->last_name);
        $this->assertEquals('jhon@mail.com', $userA->email);
        $this->assertTrue(Hash::check('admin123456', $userA->password));
        $response->assertRedirect(route('users.index'));
    }

    /**
     * @param string $field
     * @param mixed|null $value
     * @test
     * @dataProvider notValidDataProvider
     */
    public function itCannotUpdateAUserWhenDataIsNotValid(string $field, $value = null)
    {
        // Arrange
        $user = factory(User::class)->create();
        $userA = factory(User::class)->create();
        $country = factory(Country::class)->create();

        $data = [
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'jhon@mail.com',
            'password' => 'admin123456',
            'password_confirmation' => 'admin123456',
            'country' => $country->id
        ];
        $data[$field] = $value;

        // Act
        $response = $this->actingAs($user)
            ->put(route('users.update', $userA), $data);

        $response->assertSessionHasErrors($field);
    }

    /**
     * @test
     */
    public function itCannotUpdateAUserWithNotUniqueEmail()
    {
        // Arrange
        $user = factory(User::class)->create(['email' => 'jhon@mail.com']);
        $userA = factory(User::class)->create();
        $country = factory(Country::class)->create();

        $data = [
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'jhon@mail.com',
            'password' => 'admin123456',
            'password_confirmation' => 'admin123456',
            'country' => $country->id,
        ];

        // Act
        $response = $this->actingAs($user)
            ->put(route('users.update', $userA), $data);

        // Assert
        $response->assertSessionHasErrors('email');
    }

    public function notValidDataProvider(): array
    {
        return [
            'Test first name is required' => ['first_name', null],
            'Test last name is required' => ['last_name', null],
            'Test email is required' => ['email', null],
            'Test first name is too short' => ['first_name', 'jo'],
            'Test last name is too short' => ['last_name', 'jo'],
            'Test first name is too long' => ['first_name', Str::random(81)],
            'Test last name is too long' => ['last_name', Str::random(81)],
            'Test email is not an email' => ['email', 'something'],
            'Test password is not confirmed' => ['password', 'asdqwe123'],
            'Test country is required' => ['country', null],
            'Test country is not numeric' => ['country', 'abs'],
            'Test country does not exists' => ['country', 5],
        ];
    }
}
