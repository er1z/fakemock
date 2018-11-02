<?php


namespace Er1z\FakeMock\Detector;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Detector\Detectors\Default_;
use Er1z\FakeMock\Detector\Detectors\DetectorInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Object_;

class DefaultFieldDetector implements FieldDetectorInterface
{

    const DEFAULT_TYPE = 'name';

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

    public function getGeneratorArgumentsForUnmapped(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations)
    {

        $type = $this->getPhpDocType($property);

        if ($type) {
            // https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace - reflection is the fastest?
            $baseClass = new \ReflectionClass($type);
            $class = sprintf('Er1z\\FakeMock\\Detector\\Detectors\\%s', $baseClass->getShortName());

            if (class_exists($class)) {
                /**
                 * @var $obj DetectorInterface
                 */
                $obj = new $class;
            }
        }else{
            $obj = new Default_();
        }

        if(isset($obj)){
            return $obj->getConfigurationForType($property, $configuration, $annotations, $type);
        }

        $configuration->method = self::DEFAULT_TYPE;

        return $configuration;
    }

}