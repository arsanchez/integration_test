<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    use WithFaker;

    public function test_missing_post_data()
    {
        // Testing the status
        $response = $this->postJson('/save', ['name' => 'test']);
        $response->assertStatus(422);

        // Testing the message 
        $data = json_decode($response->content());
        $this->assertEquals('The given data was invalid.', $data->message);
    }

    public function test_valid_data()
    {
        $test_email = preg_replace('/@example\..*/', '@domain.com', $this->faker->unique()->safeEmail);
        // Testing the status
        $response = $this->postJson('/save', ['email'=> $test_email, 'name' => 'test random', 'country' => 'DR']);
        $response->assertStatus(200);

        // Testing the message 
        $data = json_decode($response->content());
        $this->assertEquals($test_email, $data->email);
    }

    public function test_update_data()
    {
        $test_name = $this->faker->name;
        // Testing the status
        $response = $this->postJson('/save', ['email'=> 'test@mail.com', 'name' => $test_name, 'country' => 'DR', 'id' => '1082946576491587875']);
        $response->assertStatus(200);

        // Testing the message 
        $data = json_decode($response->content());
        $this->assertEquals($test_name, $data->name);
    }
    

    public function test_duplicated_email()
    {
        // Testing the status
        $response = $this->postJson('/save', ['name' => 'test', 'email' => 'test@mail.com', 'country' => 'DR']);
        $response->assertStatus(422);

        // Testing the message 
        $data = json_decode($response->content());
        $this->assertEquals('This email is already in use.', $data->errors->email[0]);
    }

    public function test_invalid_delete()
    {
        // Testing the status
        $response = $this->get('/delete/1243');
        $response->assertStatus(200);

        // Testing the message 
        $response->assertJson([
            'error' => [
                'code' => 123,
                'message' => 'Subscriber not found'
            ]
        ]);
    }


}
