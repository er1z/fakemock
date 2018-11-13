<?php

namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Decorator\AssertDecorator\Length;
use Er1z\FakeMock\Metadata\FieldMetadata;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class LengthTest extends TestCase
{
    use AssertsTestTrait;

    public function testLengthOk()
    {
        $decorator = new Length();

        $str = $oldStr = 'lorem ipsum';

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\Length([
            'min' => 3,
            'max' => 20,
        ]));

        $this->assertTrue($result);
        $this->assertEquals($str, $oldStr);
    }

    public function testLengthInsufficient()
    {
        $decorator = new Length();

        $str = 'lorem';

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\Length([
            'min' => 10,
        ]));

        $this->assertTrue($result);
        $this->assertGreaterThanOrEqual(10, strlen($str));
    }

    public function testLengthExceeds()
    {
        $decorator = new Length();

        $str = 'lorem ipsum';

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\Length([
            'max' => 9,
        ]));

        $this->assertTrue($result);
        $this->assertLessThanOrEqual(10, strlen($str));
    }
}
