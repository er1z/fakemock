<?php
namespace Tests\Er1z\FakeMock\Mocks\Struct;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock()
 */
class Explicit
{

    /**
     * @FakeMockField(value="test value")
     * @var string
     */
    public $value;

    /**
     * @FakeMockField(regex="\d{2}\-\d{3}")
     * @var string
     */
    public $regex;

    /**
     * @FakeMockField(faker="name")
     * @var string
     */
    public $fakedName;

}