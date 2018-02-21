<?php

namespace PlanB\Wand\Core\Context\Property;

use PlanB\Utils\Dev\Tdd\Test\Unit;

use PlanB\Utils\Tdd\Mock\Double;

use PlanB\Wand\Core\Context\Property;

/**
 * LicenseProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property
 */
class LicensePropertyTest extends Unit
{


    /**
     * @test
     *
     * @covers ::create
     * @covers ::__construct
     * @covers ::build
     * @covers ::getPath
     * @covers ::getQuestion
     * @covers ::getOptions
     * @covers \PlanB\Wand\Core\Context\Property\LicenseProperty::getOptions
     * @covers \PlanB\Wand\Core\Context\Property\LicenseProperty::init
     */
    public function testCreate()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $this->assertInstanceOf(LicenseProperty::class, $target);
        $this->assertInstanceOf(Property::class, $target);

        $this->assertEquals('[license]', $target->getPath());
        $this->assertEquals('License: ', $target->getQuestion()->getMessage());

        $this->assertEquals([
            'MIT',
            'Apache-2.0',
            'Unlicense'
        ], $target->getOptions());
    }


    /**
     * @test
     *
     * @covers ::create
     * @covers ::build
     * @covers ::addWarning
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::custom
     */
    public function testWarning()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $target->addWarning('value');

        $this->assertContains("El valor 'value' no está entre los esperados (MIT|Apache-2.0|Unlicense)",
            $target->getQuestion()->getMessage());
    }


    /**
     * @test
     * @covers ::normalize
     */
    public function testNormalize()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $this->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $this->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $this->assertEquals('answer', $target->resolve('answer'));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     *
     * @covers  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::notInOptions
     */
    public function testIsValid()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $this->assertTrue($target->isValid('MIT'));
        $this->assertTrue($target->isValid('Apache-2.0'));
        $this->assertTrue($target->isValid('Unlicense'));

        $this->assertFalse($target->isValid('texto'));
        $this->assertFalse($target->isValid([]));
        $this->assertFalse($target->isValid(4545));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     *
     * @expectedException  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     * @expectedExceptionMessage El parámetro solicitado es requerido
     */
    public function testCheckNull()
    {
        /** @var LicenseProperty $target */
        $target = LicenseProperty::create();

        $target->check(null);
    }

}