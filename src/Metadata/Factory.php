<?php

namespace Er1z\FakeMock\Metadata;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\Type;

class Factory implements FactoryInterface
{
    protected $reader;

    public function __construct(?Reader $reader = null)
    {
        // can't wait for v2...
        if (class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }

        $this->reader = $reader ?: new AnnotationReader();
    }

    public function getObjectConfiguration(\ReflectionClass $object): ?FakeMock
    {
        return $this->reader->getClassAnnotation($object, FakeMock::class);
    }

    public function create($object, FakeMock $objectConfiguration, \ReflectionProperty $property): ?FieldMetadata
    {
        $annotations = new AnnotationCollection($this->reader->getPropertyAnnotations($property));
        $fieldAnnotation = $annotations->findOneBy(FakeMockField::class);

        /*
         * @var FakeMockField
         */
        if (!$fieldAnnotation) {
            return null;
        }

        $type = $this->getPhpDocType($property);
        $configuration = $this->mergeGlobalConfigurationWithLocal($objectConfiguration, $fieldAnnotation);

        return new FieldMetadata(
            $object, $property, $type, $annotations, $configuration
        );
    }

    protected function mergeGlobalConfigurationWithLocal(FakeMock $objectConfig, FakeMockField $fieldConfig): FakeMockField
    {
        if (is_null($fieldConfig->useAsserts)) {
            $fieldConfig->useAsserts = $objectConfig->useAsserts;
        }

        if (is_null($fieldConfig->satisfyAssertsConditions)) {
            $fieldConfig->satisfyAssertsConditions = $objectConfig->satisfyAssertsConditions;
        }

        return $fieldConfig;
    }

    protected function getPhpDocType(\ReflectionProperty $property): ?Type
    {
        $factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $docComment = $property->getDocComment();

        if (!$docComment) {
            return null;
        }

        $data = $factory->create(
            $docComment
        );

        /*
         * @var Tag
         */
        if ($vars = $data->getTagsByName('var')) {
            return $vars[0]->getType();
        }

        return null;
    }
}
