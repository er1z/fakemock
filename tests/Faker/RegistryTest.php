<?php


namespace Tests\Er1z\FakeMock\Faker;


use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Faker\Registry;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Provider\pl_PL\Person;
use Faker\Provider\en_US\Person as PersonEnUs;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{

    public function testGetGeneratorForField()
    {
        $field = new FieldMetadata();
        $field->configuration = new FakeMockField();
        $field->configuration->locale = 'pl_PL';

        $registry = new Registry();
        $result = $registry->getGeneratorForField($field);

        $found = false;
        foreach($result->getProviders() as $p){
            if($p instanceof Person){
                $found = true;
                break;
            }
        }

        $this->assertTrue($found);
    }

    public function testGetGeneratorForLocale()
    {

        $registry = new Registry();
        $result = $registry->getGeneratorForLocale('pl_PL');

        $found = false;
        foreach($result->getProviders() as $p){
            if($p instanceof Person){
                $found = true;
                break;
            }
        }

        $this->assertTrue($found);
    }

    public function testGetGuesserForLocale()
    {
        $registry = new Registry();

        $guesser = $registry->getGuesserForLocale('pl_PL');

        $prop = new \ReflectionProperty($guesser, 'generator');
        $prop->setAccessible(true);

        $val = $prop->getValue($guesser);

        $found = false;
        foreach($val->getProviders() as $p){
            if($p instanceof Person){
                $found = true;
                break;
            }
        }

        $this->assertTrue($found);

    }

    public function testGetGeneratorForEmpty()
    {

        $registry = new Registry();
        $result = $registry->getGeneratorForLocale();

        $found = false;
        foreach($result->getProviders() as $p){
            if($p instanceof PersonEnUs){
                $found = true;
                break;
            }
        }

        $this->assertTrue($found);
    }

}