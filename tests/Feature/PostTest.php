<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase {
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testExample() {
        $response = $this->get('/');

        $response->assertStatus(200);
    }




    /** @test */
    public function aUserCanReadAllThePosts() {
        //Given we have post in the database
        $post = factory('App\Post')->create();

        //When we visit the posts page
        $response = $this-> get('/posts');

        //Then we should be able to see all the posts
        $response->assertSee($post->title);


    }


    /** @test */
    public function aUserCanSeeASinglePost() {
        //Given we have a post in the database
        $post = factory('App\Post')->create();

        //When we visit the post URL
        $response = $this->get('/posts/'.$post->id);

        //Then we can see the post's title and body
        $response->assertSee($post->title)
                    ->assertSee($post->body);
    }

    /** @test */
    public function authenticatedUserCanCreateAPost() {
        //Given we have an authenticated user
        $this->actingAs(factory('App\User')->create());
        //And a post
        $post = factory('App\Post')->create();

        //When that user creates a post
        $this->post('/posts/create', $post->toArray());

        //Then the post will be stored in the database
        $this->assertEquals(1, Post::all()->count());
    }

    /** @test */
    public function unauthorizedUserCanNotCreateAPost() {
        //Given we have a guest user who wants to create a post
        $post = factory('App\Post')->make();

        //When that user submits the post request to create a post
        //He will be redirected to login
        $this->get('/posts/create', $post->toArray())
                        ->assertRedirect('/login');
    }


    /** @test */
    public function aPostRequiresATitle(){
        //Given we have a user who wants to crate a post
        $this->actingAs(factory('App\User')->create());
        //But the post doesn't have any title
        $post = factory('App\Post')->make(['title' => null]);

        //When we try to store the post in the database
        $this->post('/posts/create', $post->toArray())
        //Then we will see the error messages saying title is required
                ->assertSee('The title field is required.');
    }

    /** @test */
    public function aPostRequiresABody(){
        //Given we have a user who wants to crate a post
        $this->actingAs(factory('App\User')->create());
        //But the post doesn't have any body
        $post = factory('App\Post')->make(['body' => null]);

        //When we try to store the post in the database
        $this->post('/posts/create', $post->toArray())
        //Then we will see the error messages saying body is required
                ->assertSee('The body field is required.');
    }

    /** @test */
    public function authenticatedUserCanUpdateAPostTitle() {
        //Given we have an authenticated user
        $this->actingAs(factory('App\User')->create());
        //And a post
        $post = factory('App\Post')->create(['user_id' => (auth()->user()->id)]);

        //When the user updates the post title
        $post->title = 'title updated';
        //and stores it in the database
        $this->put('/posts/'.$post->id, $post->toArray());

        //Then the post will be updated in the database
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => $post->title]);
    }

    /** @test */
    public function authenticatedUserCanUpdateAPostBody() {
        //Given we have an authenticated user
        $this->actingAs(factory('App\User')->create());
        //And a post
        $post = factory('App\Post')->create(['user_id' => (auth()->user()->id)]);

        //When the user updates the post body
        $post->body = 'body updated';
        //and stores it in the database
        $this->put('/posts/'.$post->id, $post->toArray());

        //Then the post will be updated in the database
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'body' => $post->body]);
    }

    /** @test */
    public function unauthorizedUserCanNotUpdateAPost() {
        //Given we have an authenticated user
        $this->actingAs(factory('App\User')->create());
        //And a post created by another user
        $post = factory('App\Post')->create();

        //When the signed in user tries to update the post created by another user by
        //going into the edit page
        $this->get('/posts/'.$post->id.'/edit', $post->toArray())
        //Then the user will be redirected to the posts page
                        ->assertRedirect('/posts');

    }

    /** @test */
    public function authenticatedUserCanDeleteAPost() {
        //Given we have an authenticated user
        $this->actingAs(factory('App\User')->create());
        //And a post
        $post = factory('App\Post')->create(['user_id' => (auth()->user()->id)]);

        //When the user deletes the post
        $this->delete('/posts/'.$post->id);

        //Then the post will be missing from the database
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function unauthorizedUserCanNotDeleteAPost() {
        //Given we have an authenticated user
        $this->actingAs(factory('App\User')->create());
        //And a post created by another user
        $post = factory('App\Post')->create();

        //When the signed in user tries to delete the post created by another user 
        $this->delete('/posts/'.$post->id)
        //Then the user will be redirected to the posts page
                        ->assertRedirect('/posts');

    }


}
