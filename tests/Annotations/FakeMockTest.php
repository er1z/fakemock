<?php

namespace Tests\Er1z\FakeMock\Annotations;

use Er1z\FakeMock\Annotations\FakeMock;
use PHPUnit\Framework\TestCase;

class FakeMockTest extends TestCase
{
    public function testInstantiationWithParams()
    {
        $data = [
            'useAsserts' => false,
        ];

        $annotation = new FakeMock($data);
        $this->assertFalse($annotation->useAsserts);
    }
}
