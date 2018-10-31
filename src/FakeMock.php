<?php


namespace Er1z\FakeMock;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Annotations\FakeMock as MainAnnotation;
use Er1z\FakeMock\Generator\DefaultGenerator;
use Er1z\FakeMock\Generator\GeneratorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FakeMock
{

    private $reader;
    /**
     * @var GeneratorInterface
     */
    private $generator;

    public function __construct(Reader $reader = null, GeneratorInterface $generator = null)
    {
        // can't wait for v2...
        if(class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }

        $this->reader = $reader ?: new AnnotationReader();
        $this->generator = $generator ?: new DefaultGenerator();
    }

    public function fill($object, $group = null)
    {
        $obj = $this->getClass($object);

        $reflection = new \ReflectionClass($obj);
        $cfg = $this->getObjectConfiguration($reflection);

        if(!$cfg){
            return $object;
        }

        return $this->populateObject($reflection, $obj, $group);
    }

    protected function populateObject(\ReflectionClass $reflection, $object, $group = null)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->getPropertyAccessor();

        $props = $reflection->getProperties();

        foreach($props as $prop){

            $annotations = new AnnotationCollection($this->reader->getPropertyAnnotations($prop));
            if(!($propMetadata = $annotations->getOneBy(FakeMockField::class))){
                continue;
            }

            if($group && !in_array($group, (array)$propMetadata->groups)){
                continue;
            }

            $value = $this->generator->generateValue($prop, $propMetadata, $annotations);

            $propertyAccessor->setValue($object, $prop->getName(), $value);
        }

        return $object;
    }

    protected function getObjectConfiguration(\ReflectionClass $object){
        return $this->reader->getClassAnnotation($object, MainAnnotation::class);
    }

    protected function getClass($objectOrClass){

        if(is_object($objectOrClass)){
            return $objectOrClass;
        }

        return new $objectOrClass;

    }


}