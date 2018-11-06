<?php


namespace Tests\Er1z\FakeMock\Annotations;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use PHPUnit\Framework\TestCase;

class AnnotationCollectionTest extends TestCase
{


    public function testGetOneByClass()
    {
        $data = [
            new FakeMock(),
            new FakeMock(),
            new FakeMockField()
        ];

        $collection = new AnnotationCollection($data);
        $result = $collection->getOneBy(FakeMockField::class);

        $this->assertInstanceOf(FakeMockField::class, $result, 'Present class');

        $this->expectException(\InvalidArgumentException::class);
        $collection->getOneBy(\RuntimeException::class);
    }

    public function testFindOneByClass()
    {
        $data = [
            new FakeMock(),
            new FakeMock(),
            new FakeMockField()
        ];

        $collection = new AnnotationCollection($data);
        $result = $collection->findOneBy(FakeMockField::class);

        $this->assertInstanceOf(FakeMockField::class, $result, 'Present class');

        $result = $collection->findOneBy(\RuntimeException::class);
        $this->assertNull($result, 'Absent class');
    }


}