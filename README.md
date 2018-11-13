Fakemock
-

[![Build Status](https://travis-ci.org/er1z/fakemock.svg?branch=dev)](https://travis-ci.org/er1z/fakemock)

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
$fakemock->fill();

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
     *]
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



FakeMock is smart enough to guess what you want to get — asserts are also decorated against specified phpDoc type, for example if you specify `LessThan` constraint and `@var float`, you get float value and so on. This features is useful when you need a `DateTimeInterface` in string:

```php
/**
 * @FakeMock()
 * @Assert\DateTime()
 * @var string
 */
```

TODO
----
- `Assert\File` mocking
- recursive fields processing when a type is supplied
- l10n support on generated data and tests
- test phpdoc type caster
- fill unit tests asserts messages

Future
-----
- refactor unit tests a bit
- try the luck with prophecy
- read asserts config from other sources than annotations