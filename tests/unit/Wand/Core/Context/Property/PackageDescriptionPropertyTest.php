<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;

/**
 * PackageDescriptionProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property
 */
class PackageDescriptionPropertyTest extends Unit
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
     * @covers \PlanB\Wand\Core\Context\Property\PackageDescriptionProperty::init
     */
    public function testCreate()
    {
        /** @var PackageDescriptionProperty $target */
        $target = PackageDescriptionProperty::create();

        $this->tester->assertInstanceOf(PackageDescriptionProperty::class, $target);
        $this->tester->assertInstanceOf(Property::class, $target);

        $this->tester->assertEquals('[description]', $target->getPath());
        $this->tester->assertEquals('Package Description: ', $target->getQuestion()->getMessage());

        $this->tester->assertEquals([], $target->getOptions());
    }


    /**
     * @test
     * @covers ::normalize
     */
    public function testNormalize()
    {
        /** @var PackageDescriptionProperty $target */
        $target = PackageDescriptionProperty::create();

        $this->tester->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var PackageDescriptionProperty $target */
        $target = PackageDescriptionProperty::create();

        $this->tester->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var PackageDescriptionProperty $target */
        $target = PackageDescriptionProperty::create();

        $this->tester->assertEquals('answer', $target->resolve('answer'));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     *
     */
    public function testIsValid()
    {
        /** @var PackageDescriptionProperty $target */
        $target = PackageDescriptionProperty::create();

        $this->tester->assertTrue($target->isValid('package description'));
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
        /** @var PackageDescriptionProperty $target */
        $target = PackageDescriptionProperty::create();

        $target->check(null);
    }

}