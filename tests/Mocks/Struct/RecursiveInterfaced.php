<?php


namespace Tests\Er1z\FakeMock\Mocks\Struct;


use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock()
 */
class RecursiveInterfaced
{

    /**
     * @var ExplicitInterface
     * @FakeMockField()
     */
    public $explicit;

}