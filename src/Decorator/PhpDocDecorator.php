<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;

class PhpDocDecorator implements DecoratorInterface
{

    const CASTABLE_TYPES = [
        'string', 'int', 'integer', 'float', 'double', 'boolean', 'bool'
    ];

    public function decorate(&$value, FieldMetadata $field, ?string $group = null): bool
    {
        if(!$field->type){
            return true;
        }

        $desiredType = (string)$field->type;

        if(in_array($desiredType, self::CASTABLE_TYPES) && gettype($value)!= $desiredType){
            $value = $this->convertTypes($field, $value, $desiredType);
        }

        return true;
    }

    protected function convertTypes(FieldMetadata $field, $value, $desiredType){
        switch(true){
            case $field->type instanceof Boolean:
                return $this->castStringToBool($value);

            case $field->type instanceof String_:
                if($value instanceof \DateTimeInterface){
                    return $this->castDateTime($value);
                }

                if(is_bool($value)){
                    return $this->castBoolToString($value);
                }

                return (string)$value;
            default:
                settype($value, $desiredType);
        }

        return $value;
    }

    protected function castDateTime(\DateTimeInterface $dateTime){
        return $dateTime->format(DATE_ATOM);
    }

    protected function castBoolToString($value){
        return $value ? 'true' : 'false';
    }

    protected function castStringToBool($value){

        $value = strtolower($value);

        switch($value){
            case 'false':
            case '0':
            default:
                return false;

            case 'true':
            case '1':
                return true;
        }

    }
}