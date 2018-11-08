<?php


namespace Er1z\FakeMock;


use Symfony\Component\PropertyAccess\PropertyAccess;

class Accessor
{

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    protected static $accessor = null;

    protected static function getAccessor()
    {
        if(!self::$accessor){
            self::$accessor = PropertyAccess::createPropertyAccessorBuilder()
                ->enableExceptionOnInvalidIndex()
                ->getPropertyAccessor();
        }

        return self::$accessor;
    }

    public static function setPropertyValue($obj, $prop, $val)
    {
        self::getAccessor()->setValue($obj, $prop, $val);
    }

    public static function getPropertyValue($obj, $prop)
    {
        return self::getAccessor()->getValue($obj, $prop);
    }

}