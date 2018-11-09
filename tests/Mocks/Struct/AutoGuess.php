<?php


namespace Tests\Er1z\FakeMock\Mocks\Struct;


use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock()
 */
class AutoGuess
{

    /**
     * @FakeMockField()
     */
    public $created_at;

    /**
     * @FakeMockField()
     */
    public $is_enabled;

    /**
     * @FakeMockField()
     */
    public $username;

    /**
     * @FakeMockField()
     */
    public $email;
}