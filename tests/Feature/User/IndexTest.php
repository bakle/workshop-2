<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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

    /**
     * @test
     * @dataProvider searchItemsProvider
     * @param string $field
     * @param string $value
     */
    public function itCanSearchUserByFirstName(string $field, string $value)
    {
        // Arrange
        $user = factory(User::class)->create();
        factory(User::class, 20)->create();
        $userA = factory(User::class)->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com'
        ]);

        $filters = [
            'filter' => [
                $field => $value
            ]
        ];

        // Act
        $response = $this->actingAs($user)
            ->get(route('users.index', $filters));
        $responseUsers = $response->getOriginalContent()['users'];

        // Assert
        $this->assertTrue($responseUsers->contains($userA));
    }

    /**
     * @param string $field
     * @param string|null $value
     * @test
     * @dataProvider notValidSearchItemsProvider
     */
    public function itFailsWhenASearchItemIsNotValid(string $field, ? string $value)
    {
        $user = factory(User::class)->create();

        $filters = [
            'filter' => [
                $field => $value
            ]
        ];

        // Act
        $response = $this->actingAs($user)
            ->get(route('users.index', $filters));

        // Assert
        $response->assertSessionHasErrors('filter.'. $field);
    }

    /**
     * @return array
     */
    public function notValidSearchItemsProvider(): array
    {
        return [
            'Test first name is too short' => ['first_name', 'jo'],
            'Test first name is too long' => ['first_name', Str::random(81)],
            'Test last name is too short' => ['last_name', 'jo'],
            'Test last name is too long' => ['last_name', Str::random(81)],
            'Test email is too long' => ['email', Str::random(81)],
            'Test email is not an email' => ['email', 'test'],
        ];
    }

    /**
     * @return array|\string[][]
     */
    public function searchItemsProvider(): array
    {
        return [
            'it can search by first name' => ['first_name', 'john'],
            'it can search by last name' => ['last_name', 'doe'],
            'it can search by email' => ['email', 'john.doe@example.com'],
        ];
    }
}
