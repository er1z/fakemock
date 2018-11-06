<?php
namespace Tests\Er1z\FakeMock\Behavior\Mocks;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructBasic
 * @FakeMock()
 */
class StructWithRegex
{

    /**
     * @FakeMockField()
     * @Assert\Regex(pattern="[0-9]{2}\-[0-9]{3}")
     */
    public $postcode;


}