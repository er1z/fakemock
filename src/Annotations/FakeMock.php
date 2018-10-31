<?php


namespace Er1z\FakeMock\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class FakeAnnotation
 * @Annotation()
 */
class FakeMock
{

    public $decorator = null;

    public function __construct($data)
    {
        // todo: translate string to array and check decorator type
        return $data;
    }

}