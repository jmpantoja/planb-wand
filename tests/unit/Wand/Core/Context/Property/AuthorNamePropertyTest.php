<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;


/**
 * AuthorNameProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property\AuthorNameProperty
 */
class AuthorNamePropertyTest  extends Unit {


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
     * @covers \PlanB\Wand\Core\Context\Property\AuthorNameProperty::init
     */
    public function testCreate()
    {
        /** @var AuthorNameProperty $target */
        $target = AuthorNameProperty::create();

        $this->tester->assertInstanceOf(AuthorNameProperty::class, $target);
        $this->tester->assertInstanceOf(Property::class, $target);

        $this->tester->assertEquals('[authors][0][name]', $target->getPath());
        $this->tester->assertEquals('Author Name: ', $target->getQuestion()->getMessage());

        $this->tester->assertEquals([], $target->getOptions());
    }


    /**
     * @test
     * @covers ::normalize
     */
    public function testNormalize()
    {
        /** @var AuthorNameProperty $target */
        $target = AuthorNameProperty::create();

        $this->tester->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var AuthorNameProperty $target */
        $target = AuthorNameProperty::create();

        $this->tester->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var AuthorNameProperty $target */
        $target = AuthorNameProperty::create();

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
        /** @var AuthorNameProperty $target */
        $target = AuthorNameProperty::create();

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
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::required
     *
     * @expectedException  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     * @expectedExceptionMessage El parámetro solicitado es requerido
     */
    public function testCheckNull()
    {
        /** @var AuthorNameProperty $target */
        $target = AuthorNameProperty::create();

        $target->check(null);
    }
    

}