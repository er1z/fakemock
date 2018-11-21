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
use phpDocumentor\Reflection\Types\ContextFactory;

class Factory implements FactoryInterface
{
    protected $reader;

    public function __construct(?Reader $reader = null)
    {
        // can't wait for v2...
        if (class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }

        $this->reader = $reader ?? new AnnotationReader();
    }

    public function getObjectConfiguration(\ReflectionClass $object): ?FakeMock
    {
        return $this->reader->getClassAnnotation($object, FakeMock::class);
    }

    /**
     * @param $object
     * @param FakeMock            $objectConfiguration
     * @param \ReflectionProperty $property
     *
     * @return FieldMetadata[]
     */
    public function create($object, FakeMock $objectConfiguration, \ReflectionProperty $property)
    {
        $annotations = new AnnotationCollection($this->reader->getPropertyAnnotations($property));
        $fieldAnnotations = $annotations->findAllBy(FakeMockField::class);

        if (!$fieldAnnotations) {
            return null;
        }

        $result = [];

        foreach ($fieldAnnotations as $a) {
            $f = new FieldMetadata();
            $f->property = $property;
            $f->objectConfiguration = $objectConfiguration;
            $f->annotations = $annotations;
            $f->type = $this->getPhpDocType($property);
            $f->object = $object;
            $f->configuration = $this->mergeGlobalConfigurationWithLocal($objectConfiguration, $a);

            $result[] = $f;
        }

        return $result;
    }

    /**
     * @param FieldMetadata[] $annotations
     * @param string|null     $group
     *
     * @return FieldMetadata[]
     */
    public function getConfigurationForFieldByGroup($annotations, ?string $group = null)
    {
        if (empty($annotations)) {
            return null;
        }

        if (is_null($group)) {
            return array_shift($annotations);
        }

        $result = array_filter($annotations, function ($item) use ($group) {
            return !empty($item->configuration->groups) && in_array($group, $item->configuration->groups);
        });

        $filtered = array_values($result);

        return array_shift($filtered);
    }

    protected function mergeGlobalConfigurationWithLocal(FakeMock $objectConfig, FakeMockField $fieldConfig): FakeMockField
    {
        if (is_null($fieldConfig->useAsserts)) {
            $fieldConfig->useAsserts = $objectConfig->useAsserts;
        }

        if (is_null($fieldConfig->satisfyAssertsConditions)) {
            $fieldConfig->satisfyAssertsConditions = $objectConfig->satisfyAssertsConditions;
        }

        if (is_null($fieldConfig->recursive)) {
            $fieldConfig->recursive = $objectConfig->recursive;
        }

        if (is_null($fieldConfig->locale)) {
            $fieldConfig->locale = $objectConfig->locale;
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

        $ctxFactory = new ContextFactory();

        $data = $factory->create(
            $docComment, $ctxFactory->createFromReflector($property)
        );

        /**
         * @var $vars Tag[]
         */
        if ($vars = $data->getTagsByName('var')) {
            return $vars[0]->getType();
        }

        return null;
    }
}
