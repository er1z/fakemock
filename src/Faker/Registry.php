<?php


namespace Er1z\FakeMock\Faker;


use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Factory;
use Faker\Generator;
use Faker\Guesser\Name;

class Registry implements RegistryInterface
{

    /**
     * @var Generator[]
     */
    protected $generators = [];

    public function getGeneratorForField(FieldMetadata $fieldMetadata)
    {
        return $this->getGeneratorForLocale($fieldMetadata->configuration->locale);
    }

    public function getGeneratorForLocale(?string $locale = null): Generator
    {

        $locale = $locale ?? Factory::DEFAULT_LOCALE;

        if(empty($this->generators[$locale])){
            $this->generators[$locale] = $this->instantiate($locale);
        }

        return $this->generators[$locale];

    }

    public function getGuesserForLocale(?string $locale = null): Name{

        $generator = $this->getGeneratorForLocale($locale);

        return new Name($generator);

    }

    protected function instantiate($locale = null){
        return Factory::create($locale ?? Factory::DEFAULT_LOCALE);
    }

}