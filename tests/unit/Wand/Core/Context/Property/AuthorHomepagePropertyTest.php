<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;

/**
 * AuthorHomepageProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property
 */
class AuthorHomepagePropertyTest extends Unit
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
     * @covers \PlanB\Wand\Core\Context\Property\AuthorHomepageProperty::init
     */
    public function testCreate()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $this->tester->assertInstanceOf(AuthorHomepageProperty::class, $target);
        $this->tester->assertInstanceOf(Property::class, $target);

        $this->tester->assertEquals('[authors][0][homepage]', $target->getPath());
        $this->tester->assertEquals('Github Username: ', $target->getQuestion()->getMessage());

        $this->tester->assertEquals([], $target->getOptions());
    }


    /**
     * @test
     *
     * @covers ::create
     * @covers ::build
     * @covers ::addWarning
     * @covers \PlanB\Wand\Core\Context\Property\AuthorHomepageProperty::getErrorMessage
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::custom
     */
    public function testWarning()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $target->addWarning('username');

        $this->tester->assertContains('El formato de author homepage "username" no es correcto, se esperaba "https://github.com/<username>/"',
            $target->getQuestion()->getMessage());
    }


    /**
     * @test
     * @covers \PlanB\Wand\Core\Context\Property\AuthorHomepageProperty::normalize
     */
    public function testNormalize()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $this->tester->assertEquals('https://github.com/username/', $target->normalize('username'));
    }


    /**
     * @test
     * @covers \PlanB\Wand\Core\Context\Property\AuthorHomepageProperty::denormalize
     */
    public function testDenormalize()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $this->tester->assertEquals('username', $target->denormalize('https://github.com/username/'));
        $this->tester->assertNull($target->denormalize('username'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $this->tester->assertEquals('answer', $target->resolve('answer'));
    }


    /**
     * @test
     * @covers ::isValid
     * @covers ::check
     * @covers ::checkNotNull
     * @covers ::checkInOptions
     * @covers ::checkCustom
     * @covers \PlanB\Wand\Core\Context\Property\AuthorHomepageProperty::validate
     *
     */
    public function testIsValid()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $this->tester->assertTrue($target->isValid('https://github.com/username/'));
        $this->tester->assertFalse($target->isValid('username'));
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
     * @covers \PlanB\Wand\Core\Context\Property\AuthorHomepageProperty::validate
     *
     * @covers \PlanB\Wand\Core\Context\Exception\InvalidAnswerException::required
     *
     * @expectedException  \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     * @expectedExceptionMessage El parámetro solicitado es requerido
     */
    public function testCheckNull()
    {
        /** @var AuthorHomepageProperty $target */
        $target = AuthorHomepageProperty::create();

        $target->check(null);
    }


}