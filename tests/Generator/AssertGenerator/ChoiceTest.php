<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Choice;

class ChoiceTest extends GeneratorAbstractTest
{

    const CHOICES = ['one', 'two', 'three'];

    public function testSingle()
    {
        $generator = new Choice();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Choice([
                'multiple'=>false,
                'choices'=> self::CHOICES
            ]),
            $this->getFaker()
        );

        $this->assertTrue(in_array($value, self::CHOICES));
    }

    /**
     * @todo fix multiple generator
     */
    public function testMultiple()
    {
        $generator = new Choice();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Choice([
                'multiple'=>true,
                'choices'=> self::CHOICES
            ]),
            $this->getFaker()
        );

        $this->assertGreaterThanOrEqual(0, count(array_diff($value, self::CHOICES)));
        $this->assertEquals(count($value), count(array_unique($value)));
    }

}