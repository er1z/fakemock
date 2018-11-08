<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Ip;
use Symfony\Component\Validator\Constraints\Ip as IpConstraint;

class IpTest extends GeneratorAbstractTest
{
    public function testIpv4()
    {
        $generator = new Ip();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new IpConstraint([
                'version'=>IpConstraint::V4
            ]),
            $this->getFaker()
        );

        $this->assertEquals(
            1, preg_match('#(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})#si', $value), 'IPv4'
        );
    }

    public function testIpv6()
    {
        $generator = new Ip();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new IpConstraint([
                'version'=>IpConstraint::V6
            ]),
            $this->getFaker()
        );

        $this->assertEquals(
            1, preg_match('#((([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])))#si', $value), 'IPv6'
        );;
    }
}