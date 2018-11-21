<?php

namespace Tests\Er1z\FakeMock\Behavior;

use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\MultipleDefinitions;

class MultipleDefinitionsGrouped extends TestCase
{
    public function testMultipleDefitions()
    {
        $f = new FakeMock();

        $struct = new MultipleDefinitions();

        $result = $f->fill($struct, 'second');

        $this->assertEquals('second group', $struct->field);
    }
}
