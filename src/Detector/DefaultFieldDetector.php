<?php


namespace Er1z\FakeMock\Detector;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\Type;

class DefaultFieldDetector implements FieldDetectorInterface
{

    const DEFAULT_TYPE = 'name';

    protected function getPhpDocType(\ReflectionProperty $property): ?Type
    {
        $factory  = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $data = $factory->create(
            $property->getDocComment()
        );

        if($vars = $data->getTagsByName('var')){
            return reset($vars)->getType();
        }

        return null;
    }

    public function getGeneratorArgumentsForUnmapped(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations){

        if($type = $this->getPhpDocType($property)){
            $key = get_class($type);
            $class = sprintf('Er1z\\FakeMock\\Detector\\Detectors\\%s', basename($key));

            if(class_exists($class)){
                /**
                 * @var $obj DetectorInterface
                 */
                $obj = new $class;
                return $obj->getConfigurationForType($property, $configuration, $annotations);
            }
        }

        $configuration->method = self::DEFAULT_TYPE;

        return $configuration;
    }
}