<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_list_all_users()
    {
        $users = User::factory()->count(3)->create();

        $controller = new UserController();
        $response = $controller->index();

        $this->assertCount(3, $response);
        $this->assertInstanceOf(User::class, $response[0]);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();

        $controller = new UserController();
        $response = $controller->show($user->id);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($user->id, $response->id);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $controller = new UserController();
        $request = new Request([
            'name' => $this->faker->name,
            'role' => $this->faker->word,
            'username' => $this->faker->userName,
        ]);
        $response = $controller->update($request, $user->id);

        $this->assertInstanceOf(User::class, $response->user);
        $this->assertEquals($user->id, $response->user->id);
        $this->assertEquals($request->name, $response->user->name);
        $this->assertEquals($request->role, $response->user->role);
        $this->assertEquals($request->username, $response->user->username);
    }

    /** @test */
    public function it_can_delete_multiple_users()
    {
        $users = User::factory()->count(3)->create();

        $controller = new UserController();
        $request = new Request([
            'data' => [$users[0]->id, $users[1]->id, $users[2]->id],
        ]);
        $response = $controller->destroy($request);

        $this->assertEquals("sucess", $response->getContent());
        $this->assertDatabaseMissing('users', ['id' => $users[0]->id]);
        $this->assertDatabaseMissing('users', ['id' => $users[1]->id]);
        $this->assertDatabaseMissing('users', ['id' => $users[2]->id]);
    }
}
