<?php

namespace Tests\Er1z\FakeMock\Mocks\Struct;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * Class StructBasic.
 *
 * @FakeMock()
 */
class WithGroups
{
    /**
     * @FakeMockField(groups={"first"}, useAsserts=false)
     */
    public $stringOne;

    /**
     * @FakeMockField(groups={"second"}, useAsserts=false)
     */
    public $stringTwo;
}
