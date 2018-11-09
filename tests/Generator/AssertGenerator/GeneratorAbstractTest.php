<?php
/**
 * Created by PhpStorm.
 * User: eRIZ
 * Date: 07.11.2018
 * Time: 23:46.
 */

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Factory;
use Faker\Generator;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;

abstract class GeneratorAbstractTest extends TestCase
{
    protected function getFieldMetadata($assertsCollection = [], ?Type $type = null)
    {
        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj,
            $prop,
            $type ?? $this->createMock(Type::class),
            new AnnotationCollection($assertsCollection),
            new FakeMockField()
        );

        return $field;
    }

    protected function getFaker(): Generator
    {
        return Factory::create();
    }
}
