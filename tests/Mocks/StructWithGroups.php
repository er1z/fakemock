<?php
namespace Tests\Er1z\FakeMock\Mocks;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructBasic
 * @FakeMock()
 */
class StructWithGroups
{

    /**
     * @FakeMockField(groups={"first"})
     */
    public $stringOne;

    /**
     * @FakeMockField(groups={"second"})
     */
    public $stringTwo;

}