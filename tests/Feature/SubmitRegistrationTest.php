<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class SubmitRegistrationTest extends TestCase
{
	use RefreshDatabase;

    function testGuestCanSubmitNewRegistraion() {
    	$response = $this->post('/register', [
    		'name' => 'qqqq',
    		'email' => 'asdf@test.com',
    		'password' => 'asdf',
    		'password_confirmation' => 'asdf',
    	]);

    	$this->assertDatabaseHas('users', [
    		'name' => 'qqqq',
    	]);

    	$response
    		->assertStatus(302)
    		->assertHeader('Location', url('/admin/chat'));

    	$this
    		->get('/admin/chat')
    		->assertSee('qqqq');
    }

    function testUserNotCreatedIfValidationFails() {
    	$response = $this->post('/register');

    	$response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    function testUserNotCreatedIfPasswordConfirmationFails() {
    	$response = $this->post('/register', [
    		'name' => 'qqqq',
    		'email' => 'asdf@test.com',
    		'password' => 'asdf',
    		'password_confirmation' => '1',
    	]);

    	$response->assertSessionHasErrors(['password']);
    }

    function testUserNotCreatedWithInvalidEmail() {
    	$this->withoutExceptionHandling();

    	$cases = [
    		'asdf', 
    		'asdf@asdf', 
    		'asdf.com', 
    		'.com', 
    		'@', 
    		'@asdf',
    		'@asdf.com', 
    		'@.com', 
    	];

    	foreach($cases as $case) {
    		try {
		    	$response = $this->post('/register', [
		    		'name' => 'qqqq',
		    		'email' => $case,
		    		'password' => 'asdf',
		    		'password_confirmation' => 'asdf',
		    	]);
    		} catch (ValidationException $e) {
    			// echo $e->validator->errors()->first('email');
    			$this->assertEquals(
    				'The email must be a valid email address.',
    				$e->validator->errors()->first('email')
    			);
    			continue;
    		}
    		$this->fail("The email $case passed validation when it should have failed.");
    	}
    }

    function testMaxLengthFailsWhenTooLong() {
    	$this->withoutExceptionHandling();

    	$name = str_repeat('a', 256);
    	$password = str_repeat('a', 256);
    	$password_confirmation = str_repeat('a', 256);

    	try {
    		$this->post('/register', compact('name', 'email', 'password', 'password_confirmation'));
    	} catch(ValidationException $e) {
    		// echo $e->validator->errors()->first('name');
    		$this->assertEquals(
				'The name may not be greater than 255 characters.',
				$e->validator->errors()->first('name')    			
    		);
    		$this->assertEquals(
				'The password may not be greater than 255 characters.',
				$e->validator->errors()->first('password')    			
    		);
    		return;
    	}

    	$this->fail('Max length should trigger a ValidationExcetion');
    }

    function testMaxLengthSucceedsWhenUnderMax() {
    	$name = str_repeat('a', 255);
    	$password = str_repeat('a', 255);
    	$password_confirmation = str_repeat('a', 255);

    	$data = [
    		'name' => str_repeat('a', 255),
    		'email' => 'asdf@asdf.com',
    		'password' => str_repeat('a', 255),
    		'password_confirmation' => str_repeat('a', 255),
    	];

    	$this->post('/register', $data);
    	$this->assertDatabaseHas('users', [
    		'email' => 'asdf@asdf.com',
    	]);
    }
}
