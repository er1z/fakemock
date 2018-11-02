<?php


namespace Er1z\FakeMock\Annotations;
use Doctrine\Common\Annotations\Annotation;

/**
 * Class FakeAnnotation
 * @Annotation()
 */
class FakeMockField
{

    /**
     * Faker method to use
     * @var string
     */
    public $method = null;

    /**
     * Options passed to a particular callback
     * @var null|mixed
     */
    public $options = null;

    /**
     * Generate structs recursively
     * @var bool
     */
    public $recursive = true;

    /**
     * Generate according to the regex
     * @var null|string
     */
    public $regex = null;

    /**
     * Use asserts for field type auto-detection
     * @var bool
     */
    public $useAsserts = true;

    /**
     * Follow asserts conditions to comply validation
     * @var bool
     */
    public $satisfyAssertsConditions = true;

    /**
     * Validation groups
     * @var null|string[]
     */
    public $groups = null;

    public function __construct($data)
    {

        if(is_array($data)){
            foreach($data as $k=>$v){
                $this->$k = $v;
            }
        }else{
            $this->method = $data;
        }

        return;
    }

}
