<?php

namespace Er1z\FakeMock\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class FakeAnnotation.
 *
 * @todo: make some options global for @see FakeMock propagated into here
 * @Annotation()
 */
class FakeMockField
{
    /**
     * Faker method to use.
     *
     * @var string
     */
    public $faker = null;

    /**
     * @var null|string
     */
    public $value = null;

    /**
     * Options passed to a particular callback or Faker.
     *
     * @var null|array
     */
    public $arguments = null;

    /**
     * Generate according to the regex.
     *
     * @var null|string
     */
    public $regex = null;

    /**
     * Use asserts for field type auto-detection.
     *
     * @var bool
     */
    public $useAsserts = null;

    /**
     * Follow asserts conditions to comply validation.
     *
     * @var bool
     */
    public $satisfyAssertsConditions = null;

    /**
     * Validation groups.
     *
     * @var null|string[]
     */
    public $groups = null;

    /**
     * Map object-type field to specified class (useful if it's an interface)
     * @var string|null
     */
    public $mapToClass = null;

    /**
     * Map sub-objects if class type is specified
     * @var bool|null
     */
    public $recursive = null;

    public function __construct($dataOrFaker = [])
    {
        if (is_array($dataOrFaker)) {
            foreach ($dataOrFaker as $k => $v) {

                if($k == 'groups'){
                    $v = (array)$v;
                }

                $this->$k = $v;
            }
        } else {
            $this->faker = $dataOrFaker;
        }
    }
}
