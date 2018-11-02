<?php


namespace Tests\Er1z\FakeMock;


use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\StructBasic;
use Tests\Er1z\FakeMock\Mocks\StructWithAsserts;
use Tests\Er1z\FakeMock\Mocks\StructWithComplexTypes;
use Tests\Er1z\FakeMock\Mocks\StructWithGroups;
use Tests\Er1z\FakeMock\Mocks\StructWithRegex;

class FakeMockTest extends TestCase
{

    protected function getReader(): Reader
    {
        return new \Doctrine\Common\Annotations\AnnotationReader();
    }

    protected function getUnleashedFieldValue($obj, $field){
        $prop = new \ReflectionProperty($obj, $field);
        $prop->setAccessible(true);

        return $prop->getValue($obj);
    }

    public function testInstantiation()
    {
        $obj = new FakeMock();
        $this->assertInstanceOf(Reader::class, $this->getUnleashedFieldValue($obj, 'reader'), 'Automatically created annotation reader instance');
        $obj = null;

        $reader = $this->getReader();
        $obj = new FakeMock($reader);
        $this->assertInstanceOf(Reader::class, $this->getUnleashedFieldValue($obj, 'reader'), 'Passed reader implements interface');
        $this->assertEquals($reader, $this->getUnleashedFieldValue($obj, 'reader'));
    }

    public function testTest()
    {
        $obj = new FakeMock();

        $struct = new StructWithRegex();
        $obj->fill($struct);


        var_dump($struct);

    }

}