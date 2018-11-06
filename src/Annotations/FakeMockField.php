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
    public $faker = null;

    /**
     * @var null|string
     */
    public $value = null;

    /**
     * Options passed to a particular callback or Faker
     * @var null|array
     */
    public $arguments = null;

    /**
     * Generate structs recursively
     * @todo: needs some more logic
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

    public function __construct($dataOrFaker = [])
    {

        if(is_array($dataOrFaker)){
            foreach($dataOrFaker as $k=> $v){
                $this->$k = $v;
            }
        }else{
            $this->faker = $dataOrFaker;
        }

        return;
    }

}
