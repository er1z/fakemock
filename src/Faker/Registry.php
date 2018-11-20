<?php


namespace Er1z\FakeMock\Faker;


use Faker\Factory;
use Faker\Generator;
use Faker\Guesser\Name;

class Registry
{

    /**
     * @var Generator[]
     */
    protected $generators = [];

    public function getGeneratorForLocale($locale = null)
    {

        if(empty($this->generators[$locale])){
            $this->generators[$locale] = $this->instantiate($locale);
        }

        return $this->generators[$locale];

    }

    public function getGuesserForLocale($locale = null){

        $generator = $this->getGeneratorForLocale($locale);

        return new Name($generator);

    }

    protected function instantiate($locale = null){
        return Factory::create($locale);
    }

}