<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;
use Er1z\FakeMock\Generator\AssertGenerator\GeneratorInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Bic;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Iban;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Ip;
use Symfony\Component\Validator\Constraints\Isbn;
use Symfony\Component\Validator\Constraints\Issn;
use Symfony\Component\Validator\Constraints\Language;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Locale;
use Symfony\Component\Validator\Constraints\Luhn;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Uuid;

class AssertGenerator extends TestCase
{

    public function testGenerateDisabledAssertConditions()
    {

        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $val = null;
        $obj = new \stdClass();
        $obj->prop = null;
        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new String_(), $this->createMock(AnnotationCollection::class), new FakeMockField([
                'useAsserts'=>false
            ])
        );

        $result = $d->generateForProperty($field);

        $this->assertNull($result);

    }

    public function testGetGeneratorForNotExisting()
    {

        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $method = new \ReflectionMethod($d, 'getGenerator');
        $method->setAccessible(true);
        $result = $method->invoke($d, 'asdasdasdasd');
        $this->assertFalse($result);

    }

    public function testGetGeneratorForExisting()
    {

        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $method = new \ReflectionMethod($d, 'getGenerator');
        $method->setAccessible(true);
        $result = $method->invoke($d, 'Ip');
        $this->assertInstanceOf(\Er1z\FakeMock\Generator\AssertGenerator\Ip::class, $result);

    }

    public function testGenerateForNoAsserts()
    {
        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new String_(), $this->createMock(AnnotationCollection::class), new FakeMockField()
        );

        $result = $d->generateForProperty($field);

        $this->assertNull($result);
    }

    public function testGenerateForMockAssert(){
        $mock = $this->getMockBuilder(GeneratorInterface::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('generateForProperty')
            ->willReturn('123');

        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $generators = new \ReflectionProperty($d, 'generators');
        $generators->setAccessible(true);
        $generators->setValue($d, [
            'Ip'=>$mock
        ]);

        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new String_(), new AnnotationCollection([
                new Ip()
        ]), new FakeMockField()
        );

        $result = $d->generateForProperty($field);

        $this->assertEquals('123', $result);
    }

    protected function forAssert($assertsCollection = [], ?Type $type = null)
    {
        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj,
            $prop,
            $type ?: $this->createMock(Type::class),
            new AnnotationCollection($assertsCollection),
            new FakeMockField()
        );

        $assertGenerator = new \Er1z\FakeMock\Generator\AssertGenerator();
        $value = $assertGenerator->generateForProperty($field);
        return $value;
    }

    public function testEmail()
    {
        $value = $this->forAssert([
            new Email()
        ]);

        $this->assertNotNull(
            filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)
        );
    }

    public function testUrl()
    {
        $value = $this->forAssert([
            new Url()
        ]);

        $this->assertNotNull(
            filter_var($value, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE)
        );
    }

    public function testRegex()
    {
        $value = $this->forAssert([
            new Regex([
                'pattern'=>'\d{5}'
            ])
        ]);

        $this->assertEquals(
            1, preg_match('#(\d{5})#si', $value)
        );
    }

    public function testUuid()
    {
        $value = $this->forAssert([
            new Uuid()
        ]);

        $this->assertEquals(
            1, preg_match('#([0-9A-Z\-]+)#si', $value)
        );
    }

    public function testIp()
    {
        $valueV4 = $this->forAssert([
            new Ip([
                'version'=>Ip::V4
            ])
        ]);

        $this->assertEquals(
            1, preg_match('#(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})#si', $valueV4), 'IPv4'
        );

        $valueV6 = $this->forAssert([
            new Ip([
                'version'=>Ip::V6
            ])
        ]);

        $this->assertEquals(
            1, preg_match('#((([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])))#si', $valueV6), 'IPv6'
        );
    }

    public function testDate()
    {
        $value = $this->forAssert([
            new Date()
        ]);

        $this->assertInstanceOf(\DateTime::class, $value);
        $this->assertEquals('00:00:00', $value->format('H:i:s'));
    }

    public function testTime()
    {
        $value = $this->forAssert([
            new Time()
        ]);

        $this->assertInternalType('string', $value);
        $this->assertRegExp('#\d{2}\:\d{2}\:\d{2}#si', $value);
    }

    public function testDateTime()
    {
        $value = $this->forAssert([
            new DateTime()
        ]);

        $this->assertInstanceOf(\DateTime::class, $value);
    }

    public function testImage()
    {

        $value = $this->forAssert([
            new Image([
                'maxWidth'=>320,
                'maxHeight'=>240
            ])
        ]);

        $this->assertInstanceOf(\SplFileObject::class, $value);
        /**
         * @var $value \SplFileObject
         */
        $imgData = getimagesize($value->getPathname());
        $this->assertNotEmpty($imgData);
        $this->assertEquals(320, $imgData[0]);
        $this->assertEquals(240, $imgData[1]);
        $this->assertStringStartsWith('image/', $imgData['mime']);
    }

    public function testBic()
    {
        $value = $this->forAssert([
            new Bic()
        ]);

        $this->assertRegExp('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $value);
    }

    public function testCurrency()
    {
        $value = $this->forAssert([
            new Currency()
        ]);

        $this->assertInternalType('string', $value);
        $this->assertEquals(3, strlen($value));
    }

    public function testLuhn()
    {
        $value = $this->forAssert([
            new Luhn()
        ]);

        $this->assertRegExp('#[0-9]+#si', $value);

    }

    public function testIban()
    {
        $value = $this->forAssert([
            new Iban()
        ]);

        $this->assertTrue(ctype_alnum($value));

    }

    public function testCard()
    {
        $value = $this->forAssert([
            new CardScheme([
                'schemes'=>['visa']
            ])
        ]);

        $this->assertRegExp('/^4[0-9]{12}(?:[0-9]{3})?$\z/i', $value);

        $this->expectException(\InvalidArgumentException::class);
        $this->forAssert([
            new CardScheme([
                'schemes'=>['blablabla']
            ])
        ]);
    }

    public function testIssn()
    {
        $value = $this->forAssert([
            new Issn()
        ]);

        $this->assertEquals(\Er1z\FakeMock\Generator\AssertGenerator\Issn::HARDCODED_ISSN, $value);
    }

    public function testLanguage()
    {
        $value = $this->forAssert([
            new Language()
        ]);

        $this->assertEquals(2, strlen($value));
    }

    public function testLocale()
    {
        $value = $this->forAssert([
            new Locale()
        ]);

        $this->assertRegExp('#[a-z]_[A-Z].*#s', $value);
    }

    public function testCountry()
    {
        $value = $this->forAssert([
            new Country()
        ]);

        $this->assertRegExp('#[A-Z]{2}#s', $value);
    }

    public function testChoice()
    {
        $items = ['one', 'two', 'three'];

        $value = $this->forAssert([
            new Choice([
                'multiple'=>false,
                'choices'=>$items
            ])
        ]);

        $this->assertTrue(in_array($value, $items));

        $multipleValues = $this->forAssert([
            new Choice([
                'multiple'=>true,
                'choices'=>$items
            ])
        ]);

        $this->assertArraySubset($multipleValues, $items);
        $this->assertEquals(count($multipleValues), count(array_unique($multipleValues)));
    }

    public function testRange()
    {
        $valueFloat = $this->forAssert([
            new Range([
                'min'=>1,
                'max'=>10
            ])
        ], new Float_());

        $this->assertInternalType('float', $valueFloat);
        $this->assertGreaterThanOrEqual(1, $valueFloat);
        $this->assertLessThanOrEqual(10, $valueFloat);

        $valueInt = $this->forAssert([
            new Range([
                'min'=>1,
                'max'=>10
            ])
        ], new Integer());

        $this->assertInternalType('int', $valueInt);
        $this->assertGreaterThanOrEqual(1, $valueInt);
        $this->assertLessThanOrEqual(10, $valueInt);
    }

    public function testIsbn()
    {
        $value = $this->forAssert([
            new Isbn()
        ]);

        $this->assertTrue(ctype_alnum($value));
        $this->assertEquals(10, strlen($value));

        $longValue = $this->forAssert([
            new Isbn(),
            new Length(['max'=>13])
        ]);

        $this->assertTrue(ctype_alnum($longValue));
        $this->assertEquals(13, strlen($longValue));


    }

}