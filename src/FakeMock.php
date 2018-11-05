<?php


namespace Er1z\FakeMock;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Annotations\FakeMock as MainAnnotation;
use Er1z\FakeMock\Condition\Processor;
use Er1z\FakeMock\Condition\ProcessorInterface;
use Er1z\FakeMock\Generator\DefaultGenerator;
use Er1z\FakeMock\Generator\GeneratorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;

class FakeMock
{

    private $reader;
    /**
     * @var GeneratorInterface
     */
    private $generator;
    /**
     * @var ProcessorInterface
     */
    private $conditionProcessor;

    public function __construct(?Reader $reader = null, ?GeneratorInterface $generator = null, ?ProcessorInterface $conditionProcessor = null)
    {
        // can't wait for v2...
        if(class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }

        $this->reader = $reader ?: new AnnotationReader();
        $this->generator = $generator ?: new DefaultGenerator();
        $this->conditionProcessor = $conditionProcessor ?: new Processor();
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
            /**
             * @var $propMetadata FakeMockField
             */
            if(!($propMetadata = $annotations->findOneBy(FakeMockField::class))){
                continue;
            }

            if($group && !in_array($group, (array)$propMetadata->groups)){
                continue;
            }

            if(empty($value)) {
                $value = $this->generator->generateValue($prop, $propMetadata, $annotations);
            }

            if($propMetadata->satisfyAssertsConditions){
                $value = $this->conditionProcessor->processConditions($value, $object, $propMetadata, $annotations, $group);
            }

            $propertyAccessor->setValue($object, $prop->getName(), $value);
        }

        return $object;
    }

    protected function checkLength($value, FakeMockField $config, AnnotationCollection $annotations){

        if(!class_exists(Constraint::class)){
            return $value;
        }

        if($lengthConfig = $annotations->findOneBy(Length::class) && $config->satisfyAssertsConditions){
            /**
             * @var $lengthConfig Length
             */
            $min = $lengthConfig->min;
            $max = $lengthConfig->max;
            if(!isset($value[$min])){
                // todo: to const
                $value = str_pad($value, strlen($value)-$min, '_');
            }else if(isset($value[$max+1])){
                $value = substr($value, 0, $max);
            }
        }

        return $value;

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