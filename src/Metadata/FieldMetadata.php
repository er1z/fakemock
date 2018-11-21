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

    public function __construct($args = [])
    {
        foreach ($args as $k => $v) {
            $this->{$k} = $v;
        }
    }
}
