<?php

namespace Tests\Er1z\FakeMock\Mocks\Struct;

use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock(locale="pl_PL")
 */
class LocaleStruct
{
    /**
     * @FakeMockField()
     */
    public $name;

    /**
     * @FakeMockField()
     */
    public $username;
}
