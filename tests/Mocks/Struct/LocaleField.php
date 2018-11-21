<?php

namespace Tests\Er1z\FakeMock\Mocks\Struct;

use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock()
 */
class LocaleField
{
    /**
     * @FakeMockField(locale="pl_PL")
     */
    public $name;

    /**
     * @FakeMockField(faker="name")
     */
    public $name2;
}
