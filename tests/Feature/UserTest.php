<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    private $validUser = [
        'first_name' => 'Anifowose',
        'last_name' => 'Habeeb',
        'middle_name' => 'Tobi',
        'username' => 'mthamayor',
        'date_of_birth' => '1994-12-26'
    ];

    private $validUser2 = [
        'first_name' => 'Anifowose',
        'last_name' => 'Habeeb',
        'middle_name' => 'Tobi',
        'username' => 'mthamayor2',
        'date_of_birth' => '1994-12-26'
    ];

    /**
     * test POST /api/user feature with invalid date of birth
     *
     * @return void
     */
    public function testStoreUsersWithInvalidDateOfBirth()
    {
        $generatedUser = $this->validUser;

        $generatedUser['date_of_birth'] = '20/10/2011';

        $response = $this->postJson('/api/user', $generatedUser, $this->headers);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'date_of_birth' => [
                    'The date of birth should follow the pattern "YYYY-MM-DD".'
                ]
            ]
        ]);
    }

    /**
     * test POST /api/user feature with empty body
     *
     * @return void
     */
    public function testStoreUsersWithEmptyBody()
    {
        $generatedUser = $this->validUser;

        $generatedUser['date_of_birth'] = '20/10/2011';

        $response = $this->postJson('/api/user', $generatedUser, $this->headers);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'date_of_birth' => [
                    'The date of birth should follow the pattern "YYYY-MM-DD".'
                ]
            ]
        ]);
    }

    /**
     * test POST /api/user feature with a user with existing username in db
     *
     * @return void
     */
    public function testStoreUsersWithExistingUsername()
    {
        $generatedUser = $this->validUser;

        User::factory()->count(1)->create($generatedUser);

        $response = $this->postJson('/api/user', $generatedUser, $this->headers);

        $response->assertStatus(409);

        $response->assertJson([
            'message' => 'Conflict.',
            'errors' => [
                'username' => [
                    'User with username already exists.'
                ],
            ]
        ]);
    }

    /**
     * test POST /api/user feature with non JSON parameters
     *
     * @return void
     */
    public function testStoreUsersWithNonJsonParameters()
    {
        $generatedUser = $this->validUser;

        User::factory()->count(1)->create($generatedUser);

        $nonJsonHeader = $this->headers;
        $nonJsonHeader['Content-Type'] = 'multipart/form-data';

        $response = $this->postJson('/api/user', $generatedUser, $nonJsonHeader);

        $response->assertStatus(406);

        $response->assertJson([
            'message' => 'Not Acceptable.',
            'errors' => [
                'Request should be of type "application/json".'
            ]
        ]);
    }

    /**
     * test POST /api/user feature with invalid username
     *
     * @return void
     */
    public function testStoreUsersWithInvalidUsername()
    {
        $invalidUsername = $this->validUser;

        $invalidUsername['username'] = '.mthamayor_';

        $response = $this->postJson('/api/user', $invalidUsername, $this->headers);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'username' => [
                    'The username should have no spaces, accept only one period, ' .
                        'multiple underscores and must not start or end with special characters.'
                ]
            ]
        ]);
    }

    /**
     * test POST /api/user feature with valid parameters
     *
     * @return void
     */
    public function testStoreUsersWithValidParameters()
    {
        $generatedUser = $this->validUser;

        $response = $this->postJson('/api/user', $generatedUser, $this->headers);

        $fullName =
            ucwords(strtolower($generatedUser['first_name'])) . ' ' .
            ucwords(strtolower($generatedUser['middle_name'])) . ' ' .
            ucwords(strtolower($generatedUser['last_name']));

        $expectedResponseDataPartial = [
            'full_name' => $fullName,
            'first_name' => ucwords(strtolower($generatedUser['first_name'])),
            'last_name' => ucwords(strtolower($generatedUser['last_name'])),
            'middle_name' => ucwords(strtolower($generatedUser['middle_name'])),
            'username' => $generatedUser['username'],
            'date_of_birth' => $generatedUser['date_of_birth'],
        ];

        $response->assertStatus(201);

        $response->assertJson([
            'data' => $expectedResponseDataPartial,
        ]);
    }

    /**
     * test GET /api/user feature
     *
     * @return void
     */
    public function testGetUsers()
    {
        $generatedUser = $this->validUser;

        User::factory()->count(1)->create($generatedUser);

        $response = $this->get('/api/user');

        $response->assertStatus(206);

        $response->assertJson([
            'data' => [
                $generatedUser
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => 10,
                'to' => 1,
                'total' => 1
            ]
        ]);
    }

    /**
     * test PATCH /api/user/{id} feature with empty request
     *
     * @return void
     */
    public function testUpdateUserWithEmptyRequest()
    {
        $generatedUser = $this->validUser;

        $user = User::factory()->create($generatedUser);

        $response = $this->patchJson(('/api/user/' . $user->id), [], $this->headers);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'first_name' => [
                    'The first name field is required when none of middle ' .
                        'name / last name / username / date of birth are present.'
                ],
                'middle_name' => [
                    'The middle name field is required when none of first name ' .
                        '/ last name / username / date of birth are present.'
                ],
                'last_name' => [
                    'The last name field is required when none of middle name ' .
                        '/ first name / username / date of birth are present.'
                ],
                'username' => [
                    'The username field is required when none of middle name ' .
                        '/ last name / first name / date of birth are present.'
                ],
                'date_of_birth' => [
                    'The date of birth field is required when none of middle name ' .
                        '/ last name / username / first name are present.'
                ]
            ]
        ]);
    }

    /**
     * test PATCH /api/user/{id} feature with taken username
     *
     * @return void
     */
    public function testUpdateUserWithTakenUsername()
    {
        $generatedUser = $this->validUser;

        $user1 = User::factory()->create($generatedUser);
        $user2 = User::factory()->create($this->validUser2);

        $response = $this->patchJson(('/api/user/' . $user1->id), ['username' => $user2->username], $this->headers);

        $response->assertStatus(409);

        $response->assertJson([
            'message' => 'Conflict.',
            'errors' => [
                'username' => 'Username taken.'
            ]
        ]);
    }

    /**
     * test PATCH /api/user/{id} feature with non existent user
     *
     * @return void
     */
    public function testUpdateUserWithNonExistentUser()
    {
        $response = $this->patchJson('/api/user/1', $this->validUser, $this->headers);

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Not found.',
            'errors' => [
                'id' => 'User with id does not exist.'
            ]
        ]);
    }

    /**
     * test PATCH /api/user/{id} feature with non existent user
     *
     * @return void
     */
    public function testUpdateUserWithValidData()
    {
        $generatedUser = $this->validUser;

        $user = User::factory()->create($generatedUser);
        
        $response = $this->patchJson(('/api/user/' . $user->id), $this->validUser2, $this->headers);

        $expectedResponseDataPartial = $this->validUser2;

        $response->assertStatus(200);

        $response->assertJson([
            'data' => $expectedResponseDataPartial,
        ]);
    }

    /**
     * test DELETE /api/user/{id} feature where user does not exist
     *
     * @return void
     */
    public function testDeleteUsersWhereUserDoesNotExist()
    {
        $response = $this->delete('/api/user/4', [], $this->headers);

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Not found.',
            'errors' => [
                'id' => 'User with id does not exist.'
            ]
        ]);
    }

    /**
     * test DELETE /api/user/{id} feature where user does exists
     *
     * @return void
     */
    public function testDeleteUsersWhereUserExist()
    {
        $generatedUser = $this->validUser;

        $user = User::factory()->create($generatedUser);

        $response = $this->delete('/api/user/' . $user->id, [], $this->headers);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'User deleted successfully.'
        ]);
    }
}
