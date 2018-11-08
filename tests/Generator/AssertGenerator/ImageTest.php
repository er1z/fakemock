<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Image;

class ImageTest extends GeneratorAbstractTest
{

    const TEST_MAX_WIDTH = 320;
    const TEST_MAX_HEIGHT = 240;

    public function testImage()
    {
        $generator = new Image();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Image([
                'maxWidth'=>self::TEST_MAX_WIDTH,
                'maxHeight'=>self::TEST_MAX_HEIGHT
            ]),
            $this->getFaker()
        );

        $this->assertInstanceOf(\SplFileObject::class, $value);
        /**
         * @var $value \SplFileObject
         */
        $imgData = getimagesize($value->getPathname());
        $this->assertNotEmpty($imgData);
        $this->assertEquals(320, $imgData[0]);
        $this->assertEquals(240, $imgData[1]);
        $this->assertStringStartsWith('image/', $imgData['mime']);
    }

}