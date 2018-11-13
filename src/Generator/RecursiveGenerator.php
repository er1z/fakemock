<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Object_;

class RecursiveGenerator implements GeneratorInterface
{

    /**
     * interface|abstract => class mapping
     * @var array
     */
    protected $classMapping = [];

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock)
    {

        $value = $this->getObjectForField($field);
        if(!$value){
            return null;
        }

        $value = $fakemock->fill($value);

        return $value;

    }

    protected function getMapping($class, FieldMetadata $field){

        if($field->configuration->mapToClass){
            return new ${$this->checkClass($class, $field->configuration->mapToClass)};
        }

        if($field->objectConfiguration->classMappings && isset($field->objectConfiguration->classMappings[$class])){
            return new ${$this->checkClass($class, $field->objectConfiguration->classMappings[$class])};
        }

        if(isset($this->classMapping[$class])){
            return new $this->classMapping[$class];
        }
    }

    protected function checkClass($type, $mapping){
        if(!class_exists($mapping)){
            throw new \InvalidArgumentException(sprintf('Class %s mapped to %s does not exist', $mapping, $type));
        }

        if($type!=$mapping && !($mapping instanceof $type)){
            throw new \InvalidArgumentException(sprintf('Class %s does not implement/extend %s', $type, $mapping));
        }

        return $mapping;
    }

    protected function getObjectForField(FieldMetadata $field){

        // may be add checking if object is really this one, desired
        $value = $field->property->getValue($field->object);

        if(is_object($value)){
            return $value;
        }

        if(!($field->type instanceof Object_)) {
            return null;
        }

        /**
         * @var Object_
         */
        $type = (string)$field->type->getFqsen();

        try {
            $class = new \ReflectionClass($type);
        }catch (\ReflectionException $ex){
            throw new \InvalidArgumentException(sprintf('Class %s does not exist', $type));
        }

        if($class->isInstantiable()) {
            return new $type;
        }

        $type = $class->getName();

        if($mapping = $this->getMapping($type, $field)) {
            return new $mapping;
        }

        // non-mapped abstract/interface
        return null;

    }

    public function addClassMapping(string $intefaceOrAbstractFqcn, string $targetFqcn)
    {
        $this->classMapping[$intefaceOrAbstractFqcn] = $targetFqcn;
    }
}