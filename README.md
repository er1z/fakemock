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
- [Populating multiple objects](#populating-multiple-objects)
- [Groups](#groups)

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
