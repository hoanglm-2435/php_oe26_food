<?php

namespace Tests\Unit\Http\Controller;

use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Faker\Factory as Faker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected $userMock;
    protected $faker;

    public function setUp(): void
    {
        $this->userMock = Mockery::mock(UserRepositoryInterface::class);
        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_function()
    {
        $this->userMock
            ->shouldReceive('showList')
            ->once()
            ->andReturn(new Collection);
        $users = new UserController($this->userMock);
        $result = $users->index();
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('admin.user_management.show_user', $result->getName());
        $this->assertArrayHasKey('users', $data);
    }

    public function test_store_function()
    {
        $this->faker = Faker::create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make('password'),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'role_id' => config('roles.customer'),
        ];
        $this->userMock
            ->shouldReceive('create')
            ->once()
            ->andReturn(true);
        $request = new UserRequest($data);
        $user = new UserController($this->userMock);
        $result = $user->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('users.index'), $result->headers->get('Location'));
        $this->assertArrayHasKey('success', $result->getSession()->all());
        $this->assertEquals(302, $result->getStatusCode());
    }

    public function test_update_function()
    {
        $data = [
            'role_id' => config('roles.admin')
        ];
        $this->userMock
            ->shouldReceive('update')
            ->with(config('test_user_controller.user_id_test'), $data)
            ->once()
            ->andReturn(true);
        $request = new Request($data);
        $user = new UserController($this->userMock);
        $result = $user->update($request, config('test_user_controller.user_id_test'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('users.index'), $result->headers->get('Location'));
        $this->assertArrayHasKey('success', $result->getSession()->all());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertTrue($result->isRedirect());
    }

    public function test_update_function_fail()
    {
        $data = [
            'role_id' => config('roles.admin')
        ];
        $this->userMock
            ->shouldReceive('update')
            ->with(config('test_user_controller.user_id_test'), $data)
            ->once()
            ->andThrow(new ModelNotFoundException);
        $request = new Request($data);
        $user = new UserController($this->userMock);
        $result = $user->update($request, config('test_user_controller.user_id_test'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('users.index'), $result->headers->get('Location'));
        $this->assertArrayHasKey('error', $result->getSession()->all());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertTrue($result->isRedirect());
    }

    public function test_destroy_function()
    {
        $this->userMock
            ->shouldReceive('delete')
            ->once()
            ->with(config('test_user_controller.user_id_test'))
            ->andReturn(true);
        $user = new UserController($this->userMock);
        $result = $user->destroy(config('test_user_controller.user_id_test'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('users.index'), $result->headers->get('Location'));
        $this->assertArrayHasKey('success', $result->getSession()->all());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertTrue($result->isRedirect());
    }

    public function test_destroy_function_fail()
    {
        $this->userMock
            ->shouldReceive('delete')
            ->once()
            ->with(config('test_user_controller.user_id_test'))
            ->andThrow(new ModelNotFoundException);
        $user = new UserController($this->userMock);
        $result = $user->destroy(config('test_user_controller.user_id_test'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('users.index'), $result->headers->get('Location'));
        $this->assertArrayHasKey('error', $result->getSession()->all());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertTrue($result->isRedirect());
    }
}
