<?php

namespace Tests\Er1z\FakeMock\Annotations;

use Er1z\FakeMock\Annotations\FakeMockField;
use PHPUnit\Framework\TestCase;

class FakeMockFieldTest extends TestCase
{
    const TEST_REGEX = '\d{1,3}';

    public function testInstantiationWithParams()
    {
        $data = [
            'faker' => true,
            'regex' => self::TEST_REGEX,
        ];

        $annotation = new FakeMockField($data);
        $this->assertTrue($annotation->faker);
        $this->assertEquals(self::TEST_REGEX, $annotation->regex);
    }

    public function testInstantiationDefault()
    {
        $annotation = new FakeMockField('name');
        $this->assertEquals('name', $annotation->faker);
    }
}
