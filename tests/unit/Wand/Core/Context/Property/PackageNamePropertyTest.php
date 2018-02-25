<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;

/**
 * PackageNameProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property
 */
class PackageNamePropertyTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::create
     * @covers ::__construct
     * @covers ::build
     * @covers ::getPath
     * @covers ::getQuestion
     * @covers ::getOptions
     * @covers \PlanB\Wand\Core\Context\Property\PackageNameProperty::init
     */
    public function testCreate()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $this->tester->assertInstanceOf(PackageNameProperty::class, $target);
        $this->tester->assertInstanceOf(Property::class, $target);

        $this->tester->assertEquals('[name]', $target->getPath());
        $this->tester->assertEquals('Package Name: ', $target->getQuestion()->getMessage());

        $this->tester->assertEquals([], $target->getOptions());
    }


    /**
     * @test
     *
     * @covers ::create
     * @covers ::build
     * @covers ::addWarning
     * @covers \PlanB\Wand\Core\Context\Property\PackageNameProperty::getErrorMessage
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::custom
     */
    public function testWarning()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $target->addWarning('no-format');

        $this->tester->assertContains('El formato de nombre "no-format" no es correcto', $target->getQuestion()->getMessage());
    }


    /**
     * @test
     * @covers ::normalize
     */
    public function testNormalize()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $this->tester->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $this->tester->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $this->tester->assertEquals('answer', $target->resolve('answer'));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     * @covers \PlanB\Wand\Core\Context\Property\PackageNameProperty::validate
     *
     */
    public function testIsValid()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $this->tester->assertTrue($target->isValid('package/name'));
        $this->tester->assertFalse($target->isValid('no-format'));
        $this->tester->assertFalse($target->isValid([]));
        $this->tester->assertFalse($target->isValid(4545));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     * @covers \PlanB\Wand\Core\Context\Property\PackageNameProperty::validate
     *
     * * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::required
     *
     * @expectedException  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     * @expectedExceptionMessage El parámetro solicitado es requerido
     */
    public function testCheckNull()
    {
        /** @var PackageNameProperty $target */
        $target = PackageNameProperty::create();

        $target->check(null);
    }
}