<?php

namespace Er1z\FakeMock\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class FakeAnnotation.
 *
 * @Annotation()
 */
class FakeMock
{
    /**
     * use asserts within field type guessing process.
     *
     * @var bool
     */
    public $useAsserts = true;

    /**
     * consider conditions such as LowerThan, EqualsTo as to be satisfied.
     *
     * @var bool
     */
    public $satisfyAssertsConditions = true;

    /**
     * Map interfaces/abstracts/so on to desired classes
     * @var string[]
     */
    public $classMappings = [];

    public function __construct($data = [])
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }
}
