<?php
namespace Tests\Er1z\FakeMock;


use Er1z\FakeMock\ObjectUtils;
use PHPUnit\Framework\TestCase;

class ObjectUtilsTest extends TestCase{


    public function testGetValue()
    {
        $obj = new \stdClass();

        $obj->prop = 'asd';

        $result = ObjectUtils::getPropertyValue($obj, 'prop');

        $this->assertEquals($obj->prop, $result);
    }

    public function testSetValue()
    {
        $obj = new \stdClass();

        $obj->prop = 'one';

        ObjectUtils::setPropertyValue($obj, 'prop', 'two');

        $this->assertEquals('two', $obj->prop);
    }

}