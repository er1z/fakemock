Fakemock
-

[![Build Status](https://travis-ci.org/er1z/fakemock.svg?branch=dev)](https://travis-ci.org/er1z/fakemock) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/er1z/fakemock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/er1z/fakemock/?branch=master) [![Latest Stable Version](https://poser.pugx.org/er1z/fakemock/v/stable)](https://packagist.org/packages/er1z/fakemock) [![Code Coverage](https://scrutinizer-ci.com/g/er1z/fakemock/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/er1z/fakemock/?branch=master) 

[Faker](https://github.com/fzaninotto/Faker) is an amazing tool for mocking things but has a one drawback — you have
to do much of work in order to map all things you need. Especially when you are working with DTOs/Entities and they
already have some assertions configured — the dev has to create very own rules from scratch.

This library solves this problem. I have introduced a `FakeMock` library that takes care of filling up as many objects
as you need.  

ToC
- [Install](#install)
- [Quick example](#quick-example)
- [Configuration](#configuration)
- [Populating multiple objects](#populating-multiple-objects)
- [Groups](#groups)
- [phpDoc](#phpdoc)
- [Supported DTOs](#supported-dtos)
- [Asserts](#asserts)
- [Supported asserts](#supported-asserts)
- [Internal architecture](#internal-architecture)
- [Advanced concepts](#advanced-concepts)

Install
-

Install the library:
```bash
composer require er1z/fakemock
```

Quick example
-

We assume all the autoloaders stuff is configured so create (or re-use) your DTO:
```php

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * @FakeMock()
 */
class MyDto {
    
    /**
     * @FakeMockField()
     */
    public $username;
    
}
```

Now — fill up above with some random data:

```php
$fakemock = new Er1z\FakeMock\FakeMock();

$dto = new MyDto();
$fakemock->fill($dto);

echo $dto->username;   // mr.handsome
```

What's happened — [Name guesser](https://github.com/fzaninotto/Faker/blob/master/src/Faker/Guesser/Name.php) is used here
so it assumed that `$username` may contain your user's login. But guessing not always would fit your needs. It's possible
to specify *any* Faker's method to fill it with random data:

```php
/**
 * @FakeMockField("name")
 */
public $username;
```

and we end up with generated some random first and last name.

Configuration
-
Some of behavior is controlled by annotations. We can specify two types of configuration: global (object-scope) and local (property-scope). All available properties for global scope:

| type | name | default value | description|
|------|------|---------------|------------|
| `bool` | `satisfyAssertsConditions` |`true`|enables/disables asserts decorator (see: [supported asserts](#supported-asserts))|
| `bool` | `useAsserts` | `true` | should FakeMock use assertions to generate data? |


Local scope:

| type | name | default value | description |
| -----|-----|-------------|-------------|
|`null`|`array`|`arguments`|`null`|an array of arguments for Faker method|
|`null`|`string`|`faker`|`null`|specify desired faker method. Set to null if you want to generator chain do it's best on guessing|
|`null`|`array\|string`|`groups`|`null`|validation groups this rule for this rule is being processed.
|`null`|`string`|`regex`|`null`|a regular expression to generate random data against|
|`null`|`bool`|`satisfyAssertConditions`|`null`|turns off or on assertion decorator — `null` inherits value from global configuration|
|`null`|`bool`|`useAsserts`|`null`|should FakeMock use validation rules to generate? If `null`, value is inherited from global configuration|
|`null`|`mixed`|`value`|`null`|literal value on field. Stops guessing|


Local scope configuration constructor has a possibility to create an annotation from string-argument which is populated to `faker` key.

Populating multiple objects
-

Developers are lazy so am I — you have to take care of thing you really need to. So let's populate a few objects:
```php

$fakemock = new FakeMock();

$results = [];

for( $a=0; $a<1000; $a++ )
{
    $results[] = $fakemock->fill(MyDto::class);
}

```

That's all. They all are fresh instances so don't be concerned the reference object would have messed anything.

Groups
-

Sometimes it's needed to populate objects conditionally. Let's try with populating every 3rd generated object. First,
declare a group of field:

```php
use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * @FakeMock()
 */
class GroupedDto {

    /**
     * @FakeMockField(groups={"first"})
     */
    public $field;
    
}
```

Generate:

```php
$fakemock = new FakeMock();

$results = [];

for( $a=0; $a<1000; $a++ )
{
    $results[] = $fakemock->fill(MyDto::class, $a%3==0 ?? 'first');
}
```

Now, check your results.

phpDoc
-
If no guess is possible and you haven't mapped any particular Faker's type, FakeMock tries to guess type according to phpDoc variable type:

```php
use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * @FakeMock()
 */
class DocDTO {
    
    /**
     * @var float
     * @FakeMockField()
     */
    public $field;
    
}
```

```php
$f = new FakeMock();
$obj = new DocDTO();

$data = $f->fill($obj);

var_dump($data->field); // eg. 1.24422
```

Supported DTOs
-
FakeMock relies on [PropertyAccess](https://github.com/symfony/property-access) component so different kinds of DTOs are supported, even Doctrine entities. You can leave an object with exposed public fields but also encapsulate data via setters and getters:

```php
use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * @FakeMock()
 */
class EncapsulatedDTO
{
    /**
     * @FakeMockField();
     */
    protected $field;
    
    public function getField()
    {
        return $this->field;
    }
    
    public function setField($field)
    {
        $this->field = $field;
    }
    
}
```

And this will just work.

Asserts
-
If your project is using [Symfony's validate](https://github.com/symfony/validate) component, it's possible to utilize validation rules to tell the FakeMock how generate fields contents. For example:

```php
use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @FakeMock()
 */
class ValidatedDTO {
    
    /**
     * @FakeMockField()
     * @Assert\Email()
     */
    public $email;
    
}
```

and calling `fill` method against this object will produce fake e-mail address on `$email` field.

Supported asserts
-

Generators:

| Assert | Support status | Description |
| --- | --- | --- |
| All | unsupported | |
| Bic | supported | Swift BIC code |
| Blank | supported | nullifies field |
| Callback | unsupported | |
| CardScheme | partial-support | generates a valid credit card number — currently only `visa`, `mastercard` and `amex` are supported |
| Choice | supported | returns a value based on choices — supported are both single and multiple |
| Collection| unsupported ||
| Count | unsupported ||
| Country | supported | generates a country code |
| Currency | supported | currency code |
| Date | partial-supported | generates a date, currently according to `DATE_ATOM` format | 
| DateTime | partial-supported | generates a date with time, currently: `ISO` format |
| Email | supported | generates a valid e-mail address |
| Expression | unsupported | |
| File | unsupported | |
| Iban | supported | generates an IBAN account number |
| Image | supported | generates a `SplFileObject` with image of specified dimensions |
| Ip | supported | generates an IPv4/v6 address |
| Isbn | supported | generates an ISBN |
| IsFalse | supported | returns false to field |
| IsNull | supported | nullifies field |
| Issn | partial-support | only single hard-coded ISSN number |
| IsTrue | supported | returns true to field |
| Language | supported | generates a string with language code |
| Locale | supported | generates a locale string |
| Luhn | partial-support | generates a credit card number for LUHN algorithm validation |
| NotBlank | supported | checks whether field is not empty |
| NotNull | supported | field is not null |
| Regex | supported | generates a string that matches pattern |
| Time | partial-supported | generates a time with `H:i:s` format |
| Type | unsupported ||
| UniqueEntity | unsupported ||
| Url | supported | generates a valid URL |
| UserPassword | unsupported | |
| Uuid | supported | generates an UUID |
| Valid | unsupported | |


Decorators/conditionals:

| Assert | support | description |
| --- | --- | --- |
| EqualTo | supported | equalizes value to specified literal or `propertyPath` field value |
| GreaterThan | supported | checks if generated value matches lower boundary (not inclusive) |
| GreaterThanOrEqual | supported | checks if generated value matches lower boundary (inclusive) | 
| IdenticalTo | partial-support | similar to `EqualTo` but also checks type, currently: alias to `EqualTo` |
| Length | supported | generates a string between min-max length boundary |
| LessThan | supported | checks if generated value matches upper boundary (not inclusive) |
| LessThanOrEqual | supported | checks if generated value matches upper boundary (inclusive) |
| NotEqualTo | supported | makes sure that field's value is different from literal or `propertyPath` field value |
| NotIdenticalTo | partial-support | similar to `NotEqualTo` but also checks type, currently: alias to `NotEqualTo` |
| Range | supported | generates a number within specified boundaries |



FakeMock is smart enough to guess what you want to get — asserts are also decorated against specified phpDoc type, for example if you specify `LessThan` constraint and `@var float`, you get float value and so on. This feature is useful when you need a `DateTimeInterface` in string:

```php
/**
 * @FakeMock()
 * @Assert\DateTime()
 * @var string
 */
```

Internal architecture
-
FakeMock is a library with fair amount of tests so you don't need to bother if you want to make a contribution and concerned your code will mess up something.

Modular architecture allows to enhance and extend functionality. The main entrypoint is a `FakeMock` class which needs three elements:
- `Metadata\FactoryInterface` — builds some information on fields metadata, eg. if it should be processed, what rules are specified and so on,
- `GeneratorChainInterface` — maintains a list of field-data generators,
- `DecoratorChainInterface` — holds a list of decorators which can be used to modify generated value according to various rules, eg. convert `DateTimeInterface` to string.

Almost all modules could be overrided thanks to passing the dependencies mostly by interfaces or constructor arguments. So feel free to play with all components.

Generating of data step-by-step:
1. Create a `FakeMock` instance with specified object/FQCN to generate (if FQCN, instantiate silently),
2. Pass object to `Metadata\FactoryInterface` in order to get main object configuration,
3. If object is configured, iterate over object properties, create `FieldMetadata` merging some configuration variables with object configuration and check if group is specified and if it should be processed,
4. Tell `GeneratorChainInterface` to `getValueForField`. Available adapters are executed one-by-one until one of them returns non-null value,
5. Run `DecoratorChainInterface` with `getDecoratedValue` — mostly, they are all ran one-by-one except currently processed returns `false` which breaks the chain,
6. Set generated value by accessor.

Default generator chain:
1. `TypedGenerator` — handles two cases: `value` or `regex`. Nothing less, nothing more,
2. `RecursiveGenerator` — if variable class has FQCN specified in phpDoc, it's processed unless `recursive` field flag is set to `false`,
2. If package `symfony/validator` is installed and available, `AssertGenerator` is being checked against,
3. `FakerGenerator` — provides methods for generating specified Faker's generator or guess field content by `NameGuesser`,
4. `PhpDocGenerator` — generates data according to the property type,
5. `LastResortGenerator` — if everything above fails, generates simple name as string.

Default decorators chain:
1. `AssertDecorator` — restrict values to validation rules — its behavior is controlled by `satisfyAssertsConditions` field configuration,
2. `PhpDocDecorator` — converts values types.

Advanced Concepts
-
This is a „skeleton” of the steps required to do something more complicated within this library. For example, we want to use mapped interfaces/abstract on DTOs. Assume structure:

```php
interface SomeDTOInterface {
    
}
```

```php
use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * @FakeMock()
 */
class InnerDTO implements SomeDTOInterface {
    
    /**
     * @FakeMockField()
     */
    public $field;
    
}
```

```php
use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;

/**
 * @FakeMock()
 */
class MainDTO {
    
    /**
     * @FakeMockField()
     * @var SomeDTOInterface
     */
    public $nested;
    
}
```

Running basic FakeMock scenario will produce nothing — `$nested` is `null`. We have to tell the library, what object should we map to desired interface.

```
$generators = GeneratorChain::getDefaultGeneratorsSet();

foreach($generators as $g)
{
    if( $g instanceof RecursiveGenerator::class )
    {
        $g->addClassMapping(SomeDTOInterface::class, InnerDTO::class);
    }
}

$generatorChain = new GeneratorChain($generators);

$fakemock = new FakeMock(null, $generatorChain);

$mainDto = new MainDto();
$result = $fakemock->fill($mainDto);
```

Of course, you also can map interfaces using annotations on the global and/or local scope.

Changelog
-

*0.2*
- New: recursive fields processing

*0.1*
- First public version



TODO
----
- ~~recursive fields processing when a type is supplied~~
- `Assert\File` mocking
- l10n support on generated data and tests
- fill unit tests asserts messages

Future
-----
- refactor unit tests a bit
- try the luck with prophecy
- read asserts config from other sources than annotations