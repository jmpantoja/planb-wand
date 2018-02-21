<?php

namespace PlanB\Wand\Core\Context\Property;

use PlanB\Utils\Dev\Tdd\Test\Unit;

use PlanB\Utils\Tdd\Mock\Double;

use PlanB\Wand\Core\Context\Property;

/**
 * PackageTypeProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property
 */
class PackageTypePropertyTest extends Unit
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
     * @covers \PlanB\Wand\Core\Context\Property\PackageTypeProperty::getOptions
     * @covers \PlanB\Wand\Core\Context\Property\PackageTypeProperty::init
     */
    public function testCreate()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->assertInstanceOf(PackageTypeProperty::class, $target);
        $this->assertInstanceOf(Property::class, $target);

        $this->assertEquals('[type]', $target->getPath());
        $this->assertEquals('Package Type: ', $target->getQuestion()->getMessage());

        $this->assertEquals([
            'library',
            'project',
            'metapackage',
            'composer-plugin'

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
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $target->addWarning('value');

        $this->assertContains("El valor 'value' no está entre los esperados (library|project|metapackage|composer-plugin)",
            $target->getQuestion()->getMessage());
    }


    /**
     * @test
     * @covers ::normalize
     */
    public function testNormalize()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

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
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->assertTrue($target->isValid('library'));
        $this->assertTrue($target->isValid('project'));
        $this->assertTrue($target->isValid('metapackage'));
        $this->assertTrue($target->isValid('composer-plugin'));

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
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::required
     *
     * @expectedException  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     * @expectedExceptionMessage El parámetro solicitado es requerido
     */
    public function testCheckNull()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $target->check(null);
    }

}