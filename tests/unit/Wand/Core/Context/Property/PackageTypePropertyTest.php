<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;

/**
 * PackageTypeProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property
 */
class PackageTypePropertyTest extends Unit
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
     * @covers \PlanB\Wand\Core\Context\Property\PackageTypeProperty::getOptions
     * @covers \PlanB\Wand\Core\Context\Property\PackageTypeProperty::init
     */
    public function testCreate()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->tester->assertInstanceOf(PackageTypeProperty::class, $target);
        $this->tester->assertInstanceOf(Property::class, $target);

        $this->tester->assertEquals('[type]', $target->getPath());
        $this->tester->assertEquals('Package Type: ', $target->getQuestion()->getMessage());

        $this->tester->assertEquals([
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

        $this->tester->assertContains("El valor 'value' no está entre los esperados (library|project|metapackage|composer-plugin)",
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

        $this->tester->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->tester->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

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
     * @covers  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::notInOptions
     */
    public function testIsValid()
    {
        /** @var PackageTypeProperty $target */
        $target = PackageTypeProperty::create();

        $this->tester->assertTrue($target->isValid('library'));
        $this->tester->assertTrue($target->isValid('project'));
        $this->tester->assertTrue($target->isValid('metapackage'));
        $this->tester->assertTrue($target->isValid('composer-plugin'));

        $this->tester->assertFalse($target->isValid('texto'));
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