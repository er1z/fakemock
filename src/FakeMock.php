<?php


namespace Er1z\FakeMock;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Annotations\FakeMock as MainAnnotation;
use Er1z\FakeMock\Detector\FieldDetectorInterface;
use Faker\Factory;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FakeMock
{

    private $reader;
    /**
     * @var string
     */
    private $locale;

    /**
     * @var FieldDetectorInterface
     */
    private $fieldDetector = null;

    public function __construct(Reader $reader = null, string $locale = Factory::DEFAULT_LOCALE)
    {
        // can't wait for v2...
        if(class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }

        $this->reader = $reader ?: new AnnotationReader();
        $this->locale = $locale;
    }

    public function setFieldDetector(?FieldDetectorInterface $detector)
    {
        $this->fieldDetector = $detector;
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

        $faker = Factory::create($this->locale);

        foreach($props as $prop){

            $annotations = new AnnotationCollection($this->reader->getPropertyAnnotations($prop));
            if(!($propMetadata = $annotations->getOneBy(FakeMockField::class))){
                continue;
            }

            if($group && !in_array($group, (array)$propMetadata->groups)){
                continue;
            }

            if($propMetadata->method){
                $method = [$propMetadata->method, (array)$propMetadata->options];
            }else if($this->fieldDetector){
                $method = $this->fieldDetector->detect($prop);
            }else{

            }

            if(!is_callable([$faker, $method])){
                throw new \InvalidArgumentException(sprintf('"%s" method is not supported by Faker', $method));
            }

            $value = call_user_func_array([$faker, $method[0]], (array)$propMetadata->options);

            $propertyAccessor->setValue($object, $prop->getName(), $value);
        }

        return $object;
    }

    protected function getFieldType(\ReflectionProperty $prop)
    {
        $factory  = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $data = $factory->create($prop->getDocComment());

        if($vars = $data->getTagsByName('var')){
            $type = $vars[0]->getType();

            if($type instanceof Float_){
                return
            }
        }


        // todo
        return 'name';
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