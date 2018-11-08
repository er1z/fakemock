<?php
namespace Tests\Er1z\FakeMock;


use Er1z\FakeMock\Accessor;
use PHPUnit\Framework\TestCase;

class AccessorTest extends TestCase{


    public function testGetValue()
    {
        $obj = new \stdClass();

        $obj->prop = 'asd';

        $result = Accessor::getPropertyValue($obj, 'prop');

        $this->assertEquals($obj->prop, $result);
    }

    public function testSetValue()
    {
        $obj = new \stdClass();

        $obj->prop = 'one';

        Accessor::setPropertyValue($obj, 'prop', 'two');

        $this->assertEquals('two', $obj->prop);
    }

}