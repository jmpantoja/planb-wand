<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;


/**
 * AuthorEmailProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property\AuthorEmailProperty
 */
class AuthorEmailPropertyTest  extends Unit {


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
     * @covers \PlanB\Wand\Core\Context\Property\AuthorEmailProperty::init
     */
    public function testCreate()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

        $this->tester->assertInstanceOf(AuthorEmailProperty::class, $target);
        $this->tester->assertInstanceOf(Property::class, $target);

        $this->tester->assertEquals('[authors][0][email]', $target->getPath());
        $this->tester->assertEquals('Author Email: ', $target->getQuestion()->getMessage());

        $this->tester->assertEquals([], $target->getOptions());
    }

    /**
     * @test
     *
     * @covers ::create
     * @covers ::build
     * @covers ::addWarning
     * @covers \PlanB\Wand\Core\Context\Property\AuthorEmailProperty::getErrorMessage
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::custom
     */
    public function testWarning()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

        $target->addWarning('no-format');

        $this->tester->assertContains('El formato de "no-format" no es correcto, se esperaba un email',
            $target->getQuestion()->getMessage());
    }


    /**
     * @test
     * @covers ::normalize
     */
    public function testNormalize()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

        $this->tester->assertEquals('answer', $target->normalize('answer'));
    }


    /**
     * @test
     * @covers ::denormalize
     */
    public function testDenormalize()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

        $this->tester->assertEquals('answer', $target->denormalize('answer'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

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
     * @covers \PlanB\Wand\Core\Context\Property\AuthorEmailProperty::validate
     */
    public function testIsValid()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

        $this->tester->assertTrue($target->isValid('pepe@example.es'));
        $this->tester->assertFalse($target->isValid('no-email'));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     * @covers \PlanB\Wand\Core\Context\Property\AuthorEmailProperty::validate
     *
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::required
     *
     * @expectedException  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     * @expectedExceptionMessage El parámetro solicitado es requerido
     */
    public function testCheckNull()
    {
        /** @var AuthorEmailProperty $target */
        $target = AuthorEmailProperty::create();

        $target->check(null);
    }


}