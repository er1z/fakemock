<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Behavior\Mocks\StructExplicit;

class ExplicitTest extends TestCase
{

    public function testExplicitClass()
    {
        
        $mocker = new FakeMock();

        $class = new StructExplicit();
        $mocker->fill($class);

        $this->assertEquals('test value', $class->value, 'Scalar value set');
        $this->assertCount(2, @explode('-', $class->regex), 'Regex value generated');
        $this->assertGreaterThanOrEqual(2, @explode(' ', $class->fakedName), 'Faked name present');
        
    }
    
}