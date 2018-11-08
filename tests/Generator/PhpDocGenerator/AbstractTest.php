<?php


namespace Tests\Er1z\FakeMock\Generator\PhpDocGenerator;


use Faker\Factory;
use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{

    protected function getGenerator(){
        return Factory::create();
    }

}