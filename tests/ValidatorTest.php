<?php

namespace SSDTest;

use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class ValidatorTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $router = $this->app->make('router');

        $router->get('/form', '\SSDTest\ValidatorController@index')->name('form');
        $router->post('validate', '\SSDTest\ValidatorController@store')->name('validate');
    }

    /**
     * Get instance of the ViewErrorBag.
     *
     * @param  array $messages
     * @return \Illuminate\Support\ViewErrorBag
     */
    protected function errorBag(array $messages): ViewErrorBag
    {
        return (new ViewErrorBag)->put('default', new MessageBag($messages));
    }

    /**
     * @test
     */
    public function non_json_request_produces_default_redirect_response_with_errors_stored_in_the_session()
    {
        $response = $this->post(route('validate'));

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertRedirect(route('form'));

        $response->assertSessionHas([
            'errors' => $this->errorBag([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'age' => ['The age field is required.']
            ])
        ]);
    }

    /**
     * @test
     */
    public function json_request_produces_json_response_without_errors_stored_in_the_session()
    {
        $response = $this->postJson(route('validate'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson($this->validationError([
            'name' => ['required'],
            'email' => ['required'],
            'age' => ['required'],
        ]));

        $response->assertSessionMissing(['errors']);
    }
}