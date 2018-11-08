<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Behavior\Mocks\StructPasswords;

class PasswordsTest extends TestCase
{

    public function testPasswords()
    {
        $f = new FakeMock();
        $obj = new StructPasswords();

        $f->fill($obj);

        $this->assertInternalType('string', $obj->password);
        $this->assertEquals($obj->password, $obj->passwordConfirm);
    }

}