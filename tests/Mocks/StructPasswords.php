<?php


namespace Tests\Er1z\FakeMock\Mocks;

use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructPasswords
 * @package Tests\Er1z\FakeMock\Mocks
 * @FakeMock()
 */
class StructPasswords
{

    /**
     * @var string
     * @FakeMockField()
     */
    public $password;

    /**
     * @Assert\EqualTo(propertyPath="password")
     * @var string
     * @FakeMockField()
     */
    public $passwordConfirm;

}