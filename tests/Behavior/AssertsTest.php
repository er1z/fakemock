<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Behavior\Mocks\StructWithAsserts;

class AssertsTest extends TestCase
{

    public function testAsserts()
    {
        $f = new FakeMock();

        $obj = new StructWithAsserts();

        $f->fill($obj);

        $this->assertInternalType('float', $obj->floatAssert);
        $this->assertInternalType('string', $obj->stringEmail);
        $this->assertNotNull(filter_var($obj->stringEmail, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE));
    }

}