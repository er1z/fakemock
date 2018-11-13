<?php


namespace Tests\Er1z\FakeMock;


use Symfony\Component\Validator\Constraint;

trait AssertsTestTrait
{

    public function setUp()
    {
        if(!class_exists(Constraint::class)) {
            $this->markTestSkipped();
        }
    }

}