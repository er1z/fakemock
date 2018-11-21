<?php

namespace Tests\Er1z\FakeMock\Mocks\Struct;

use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

/**
 * @FakeMock()
 */
class MultipleDefinitions
{
    /**
     * @FakeMockField(value="first group", groups={"first"})
     * @FakeMockField(value="second group", groups={"second"})
     *
     * @var string
     */
    public $field;
}
