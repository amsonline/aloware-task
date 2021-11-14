<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Comment;

class CommentTest extends TestCase
{

    use RefreshDatabase;

    private $uri = "/api/comment/store";

    /**
     * Testing to add a valid comment
     *
     * @return void
     */
    public function test_create_valid_comment()
    {
        $response = $this->post($this->uri, [
            'username'      => 'Ahmad',
            'content'       => 'This is a test comment'
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(["success" => true]);

        $response->assertJsonCount(1, "data");
    }

    /**
     * Testing to add a valid comment reply
     *
     * @return void
     */
    public function test_create_valid_comment_with_parent_id()
    {
        $comment = new Comment;
        $comment->username = "Ahmad";
        $comment->content = "Testing comments";
        $comment->save();

        $response = $this->post($this->uri, [
            'username'      => 'Ahmad',
            'content'       => 'This is a test reply',
            'parent_id'     => $comment->id
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(["success" => true]);

        $response->assertJsonCount(2, "data");
    }

    /**
     * Trying to add a completely empty comment
     *
     * @return void
     */
    public function test_create_empty_comment()
    {
        $response = $this->post($this->uri, [
            'username'      => '',
            'content'       => ''
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["success" => false]);

        // These assertions can be changed to tags
        $response->assertSeeText("We need to know your name");
        $response->assertSeeText("Comments cannot be empty");
    }

    /**
     * Trying to add a comment with empty name
     *
     * @return void
     */
    public function test_create_empty_name_comment()
    {
        $response = $this->post($this->uri, [
            'username'      => '',
            'content'       => 'Hello, world!'
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["success" => false]);

        // These assertions can be changed to tags
        $response->assertSeeText("We need to know your name");
    }

    /**
     * Trying to add a comment with empty content
     *
     * @return void
     */
    public function test_create_empty_content_comment()
    {
        $response = $this->post($this->uri, [
            'username'      => 'Ahmad',
            'content'       => ''
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["success" => false]);

        // These assertions can be changed to tags
        $response->assertSeeText("Comments cannot be empty");
    }

    /**
     * Trying to add a comment with wrong reply id
     *
     * @return void
     */
    public function test_create_comment_with_wrong_parent_id()
    {
        $response = $this->post($this->uri, [
            'username'      => 'Ahmad',
            'content'       => 'This is a test comment',
            'parent_id'     => 1000 // Our test DB does not have this ID for sure!
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["success" => false]);

        // These assertions can be changed to tags
        $response->assertSeeText("Comment reply is invalid");
    }

    /**
     * Trying to add a comment which replies to another comment at third level of comment replies
     *
     * @return void
     */
    public function test_create_comment_with_level_3_parent_id()
    {
        // Create first level
        $firstComment = new Comment;
        $firstComment->username = "Ahmad";
        $firstComment->content = "Level 1 comment";
        $firstComment->save();

        // Create second level
        $secondComment = new Comment;
        $secondComment->username = "Ahmad";
        $secondComment->content = "Level 2 comment";
        $secondComment->parent_id = $firstComment->id;
        $secondComment->save();

        // Create third level
        $thirdComment = new Comment;
        $thirdComment->username = "Ahmad";
        $thirdComment->content = "Level 3 comment";
        $thirdComment->parent_id = $secondComment->id;;
        $thirdComment->save();

        $response = $this->post($this->uri, [
            'username'      => 'Ahmad',
            'content'       => 'This is a test comment',
            'parent_id'     => $thirdComment->id
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["success" => false]);

        // These assertions can be changed to tags
        $response->assertSeeText("This comment cannot be replied");
    }
}
