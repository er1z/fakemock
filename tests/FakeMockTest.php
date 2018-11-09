<?php


namespace Tests\Er1z\FakeMock;


use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\Factory;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\Explicit;
use Tests\Er1z\FakeMock\Mocks\Struct\Ignored;
use Tests\Er1z\FakeMock\Mocks\Struct\OnlyClassConfigured;
use Tests\Er1z\FakeMock\Mocks\Struct\SingleGroup;


class FakeMockTest extends TestCase
{

    protected function getMetadataFactory(): Factory
    {
        return new Factory();
    }

    protected function getUnleashedFieldValue($obj, $field){
        $prop = new \ReflectionProperty($obj, $field);
        $prop->setAccessible(true);

        return $prop->getValue($obj);
    }

    public function testInstantiation()
    {
        $obj = new FakeMock();
        $this->assertInstanceOf(Factory::class, $this->getUnleashedFieldValue($obj, 'metadataFactory'));
        $obj = null;

        $reader = $this->getMetadataFactory();
        $obj = new FakeMock($reader);
        $this->assertInstanceOf(Factory::class, $this->getUnleashedFieldValue($obj, 'metadataFactory'), 'Passed reader implements interface');
        $this->assertEquals($reader, $this->getUnleashedFieldValue($obj, 'metadataFactory'));
    }

    public function testFillForNotConfigured()
    {
        $fakemock = new FakeMock();
        $ignored = new Ignored();

        $result = $fakemock->fill($ignored);

        $this->assertInstanceOf(Ignored::class, $result);
        $this->assertEquals(null, $ignored->string);
    }

    public function testFillWithInstantiation(){
        $fakemock = new FakeMock();

        /**
         * @var Explicit $result
         */
        $result = $fakemock->fill(Explicit::class);

        $this->assertInstanceOf(Explicit::class, $result);
        $this->assertNotNull($result->value);
    }

    public function testOnlyClassConfigured(){
        $fakemock = new FakeMock();

        $mock = new OnlyClassConfigured();

        $result = $fakemock->fill($mock);

        $this->assertInstanceOf(OnlyClassConfigured::class, $result);
        $this->assertNull($mock->field);
    }

    public function testMissedGroup(){
        $fakemock = new FakeMock();

        $mock = new SingleGroup();

        $result = $fakemock->fill($mock, 'non-existing');

        $this->assertInstanceOf(SingleGroup::class, $result);
        $this->assertNull($mock->name);
    }

}