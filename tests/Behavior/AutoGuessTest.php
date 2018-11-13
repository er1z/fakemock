<?php

namespace Tests\Er1z\FakeMock\Behavior;

use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\AutoGuess;

class AutoGuessTest extends TestCase
{
    public function testAutoGuess()
    {
        $fakemock = new FakeMock();
        $obj = new AutoGuess();

        $fakemock->fill($obj);

        $this->assertInstanceOf(\DateTimeInterface::class, $obj->created_at);
        $this->assertNotNull(filter_var($obj->email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE));
        $this->assertInternalType('bool', $obj->is_enabled);
        $this->assertNotEmpty($obj->username);
    }
}
