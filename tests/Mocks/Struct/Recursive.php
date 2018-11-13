<?php


namespace Tests\Er1z\FakeMock\Mocks\Struct;


use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock()
 */
class Recursive
{

    /**
     * @var Explicit
     * @FakeMockField()
     */
    public $explicit;

}