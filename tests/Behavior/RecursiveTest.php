<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\Explicit;
use Tests\Er1z\FakeMock\Mocks\Struct\Recursive;

class RecursiveTest extends TestCase
{

    public function testRecursiveFill()
    {
        $f = new FakeMock();

        $struct = new Recursive();
        $result = $f->fill($struct);

        $this->assertInstanceOf(Explicit::class, $result->explicit);
    }

}