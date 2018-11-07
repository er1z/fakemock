<?php


namespace Er1z\FakeMock;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Annotations\FakeMock as MainAnnotation;
use Er1z\FakeMock\Decorator\DecoratorChain;
use Er1z\FakeMock\Decorator\DecoratorChainInterface;
use Er1z\FakeMock\Generator\GeneratorChain;
use Er1z\FakeMock\Generator\GeneratorChainInterface;
use phpDocumentor\Reflection\Type;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FakeMock
{

    /**
     * @var AnnotationReader
     */
    private $reader;
    /**
     * @var GeneratorChainInterface
     */
    private $generatorChain;
    /**
     * @var DecoratorChainInterface
     */
    private $decoratorChain;

    public function __construct(
        ?Reader $reader = null, ?GeneratorChainInterface $generatorChain = null, ?DecoratorChainInterface $decoratorChain = null
    )
    {
        // can't wait for v2...
        if (class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }

        $this->reader = $reader ?: new AnnotationReader();
        $this->generatorChain = $generatorChain ?: new GeneratorChain();
        $this->decoratorChain = $decoratorChain ?: new DecoratorChain();
    }

    public function fill($object, $group = null)
    {
        $obj = $this->getClass($object);

        $reflection = new \ReflectionClass($obj);
        $cfg = $this->getObjectConfiguration($reflection);

        if (!$cfg) {
            return $object;
        }

        return $this->populateObject($reflection, $obj, $group);
    }

    protected function populateObject(\ReflectionClass $reflection, $object, $group = null)
    {
        $props = $reflection->getProperties();

        foreach ($props as $prop) {

            $annotations = new AnnotationCollection($this->reader->getPropertyAnnotations($prop));
            /**
             * @var $propMetadata FakeMockField
             */
            if (!($propMetadata = $annotations->findOneBy(FakeMockField::class))) {
                continue;
            }

            if ($group && !in_array($group, (array)$propMetadata->groups)) {
                continue;
            }

            $metadata = new FieldMetadata(
                $object, $prop, $this->getPhpDocType($prop), $annotations, $propMetadata
            );

            $value = $this->generatorChain->getValueForField($metadata);
            $value = $this->decoratorChain->getDecoratedValue($value, $metadata);

            ObjectUtils::setPropertyValue($object, $prop->getName(), $value);
        }

        return $object;
    }

    protected function getPhpDocType(\ReflectionProperty $property): ?Type
    {
        $factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $data = $factory->create(
            $property->getDocComment()
        );

        if ($vars = $data->getTagsByName('var')) {
            return reset($vars)->getType();
        }

        return null;
    }

    protected function getObjectConfiguration(\ReflectionClass $object)
    {
        return $this->reader->getClassAnnotation($object, MainAnnotation::class);
    }

    protected function getClass($objectOrClass)
    {

        if (is_object($objectOrClass)) {
            return $objectOrClass;
        }

        return new $objectOrClass;

    }

}