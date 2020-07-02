<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_can_register()
    {
        $this->get(route('register'))->assertSuccessful();

        $this->post(
            route('register'),
            $this->userValidData()
        )->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'devCarlos2',
            'first_name' => 'Carlos',
            'last_name' => 'Developer',
            'email' => 'carlos@gmail.com',
        ]);

        $this->assertTrue(
            Hash::check('password',User::first()->password), 'The password needs to be hashed'
        );
    }

    protected function userValidData($overrides = [])
    {
        return array_merge([
            'name' => 'devCarlos2',
            'first_name' => 'Carlos',
            'last_name' => 'Developer',
            'email' => 'carlos@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $overrides);
    }

    /**
     * @test
     */
    public function the_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => null])
        )->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function the_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 1234])
        )->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => Str::random(61)])
        )->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function the_name_must_be_unique()
    {
        factory(User::class)->create(['name' => 'devCarlos']);

        $this->post(
            route('register'),
            $this->userValidData(['name' => 'devCarlos'])
        )->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function the_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 'Carlos Dev'])
        )->assertSessionHasErrors('name');

        $this->post(
            route('register'),
            $this->userValidData(['name' => 'Carlos Dev*'])
        )->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function the_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 'ab'])
        )->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /**
     * @test
     */
    public function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 1234])
        )->assertSessionHasErrors('first_name');
    }

    /**
     * @test
     */
    public function the_first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => Str::random(61)])
        )->assertSessionHasErrors('first_name');
    }

    /**
     * @test
     */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'ab'])
        )->assertSessionHasErrors('first_name');
    }

    /**
     * @test
     */
    public function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'Carlos Dev2'])
        )->assertSessionHasErrors('first_name');

        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'Carlos*'])
        )->assertSessionHasErrors('first_name');
    }

    /**
     * @test
     */
    public function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => null])
        )->assertSessionHasErrors('last_name');
    }

    /**
     * @test
     */
    public function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 1234])
        )->assertSessionHasErrors('last_name');
    }

    /**
     * @test
     */
    public function the_last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => Str::random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /**
     * @test
     */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'ab'])
        )->assertSessionHasErrors('last_name');
    }

    /**
     * @test
     */
    public function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'Carlos Dev2'])
        )->assertSessionHasErrors('last_name');

        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'Carlos*'])
        )->assertSessionHasErrors('last_name');
    }

    /**
     * @test
     */
    public function the_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => null])
        )->assertSessionHasErrors('email');
    }

    /**
     * @test
     */
    public function the_email_must_be_a_valid_email_address()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => 'invalidemail'])
        )->assertSessionHasErrors('email');
    }

    /**
     * @test
     */
    public function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'carlos@gmail.com']);

        $this->post(
            route('register'),
            $this->userValidData(['email' => 'carlos@gmail.com'])
        )->assertSessionHasErrors('email');
    }

    /**
     * @test
     */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /**
     * @test
     */
    public function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 1234])
        )->assertSessionHasErrors('password');
    }

    /**
     * @test
     */
    public function the_password_must_be_at_least_8_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 'abcdefg'])
        )->assertSessionHasErrors('password');
    }

    /**
     * @test
     */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidData([
                'password' => 'password',
                'password_confirmation' => null])
        )->assertSessionHasErrors('password');
    }
}
