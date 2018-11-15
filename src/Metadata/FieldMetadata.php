<?php

namespace Er1z\FakeMock\Metadata;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\Type;

class FieldMetadata
{
    /**
     * @var object
     */
    public $object;
    /**
     * @var \ReflectionProperty
     */
    public $property;
    /**
     * @var Type|null
     */
    public $type;
    /**
     * @var AnnotationCollection
     */
    public $annotations;
    /**
     * @var FakeMockField
     */
    public $configuration;
    /**
     * @var FakeMock
     */
    public $objectConfiguration;

    public function __construct(
        $object,
        \ReflectionProperty $property,
        ?Type $type,
        AnnotationCollection $annotations,
        FakeMockField $configuration,
        FakeMock $objectConfiguration
    ) {
        $this->object = $object;
        $this->property = $property;
        $this->type = $type;
        $this->annotations = $annotations;
        $this->configuration = $configuration;
        $this->objectConfiguration = $objectConfiguration;
    }
}
