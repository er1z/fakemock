<?php


namespace Er1z\FakeMock\Generator\RecursiveGenerator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Object_;

class ClassMapper implements ClassMapperInterface
{

    protected $classMapping = [];

    protected function getMapping(string $class, FieldMetadata $field){

        if($field->configuration->mapToClass){
            return $this->getObject($class, $field->configuration->mapToClass);
        }

        if($field->objectConfiguration->classMappings && isset($field->objectConfiguration->classMappings[$class])){
            return $this->getObject($class, $field->objectConfiguration->classMappings[$class]);
        }

        if(isset($this->classMapping[$class])){
            return $this->getObject($class, $this->classMapping[$class]);
        }
    }

    protected function getClassFromFqsen(?string $type = null): ?\ReflectionClass{

        try {
            $class = new \ReflectionClass($type);
        }catch (\ReflectionException $ex){
            throw new \InvalidArgumentException(sprintf('Class %s does not exist', $type));
        }

        return $class;

    }

    protected function getObject(string $subject, string $mapping){
        if(!class_exists($mapping)){
            throw new \InvalidArgumentException(sprintf('Class %s mapped to %s does not exist', $subject, $mapping));
        }

        $object = new $mapping();

        if($mapping!=$subject && !($object instanceof $subject)){
            throw new \InvalidArgumentException(sprintf('Class %s does not implement/extend %s', $mapping, $subject));
        }

        return $object;
    }

    public function getObjectForField(FieldMetadata $field){

        $value = $field->property->getValue($field->object);

        if(is_object($value)){
            return $value;
        }

        if(!($field->type instanceof Object_)) {
            return null;
        }

        $fqsen = (string)$field->type->getFqsen();

        if(empty($fqsen)){
            return null;
        }

        $class = $this->getClassFromFqsen($fqsen);

        if($mapping = $this->getMapping($class->getName(), $field)) {
            return $mapping;
        }

        if($class->isInstantiable()){
            return new $fqsen;
        }

        // non-mapped abstract/interface
        return null;

    }

    public function addClassMapping(string $abstractOrInterface, string $class)
    {
        $this->classMapping[$abstractOrInterface] = $class;
    }
}