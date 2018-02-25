<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger\Message;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;


/**
 * Class LogMessageTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Question\QuestionMessage
 */
class QuestionMessageTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::getMessage
     *
     * @covers ::setDefault
     * @covers ::getDefault
     *
     * @covers ::setValidator
     * @covers ::getValidator
     *
     * @covers ::setNormalizer
     * @covers ::getNormalizer
     *
     * @covers ::hasOptions
     * @covers ::getOptions
     * @covers ::setOptions
     *
     * @covers ::setWarning
     */
    public function testCreate()
    {
        $question = QuestionMessage::create('message')
            ->setValidator(function () {
            })
            ->setNormalizer(function () {
            });

        $this->tester->assertInstanceOf(QuestionMessage::class, $question);
        $this->tester->assertEquals('message', $question->getMessage());

        $this->tester->assertInternalType('callable', $question->getValidator());
        $this->tester->assertInternalType('callable', $question->getNormalizer());

        $this->tester->assertFalse($question->hasOptions());


        $options = ['A', 'B', 'C'];
        $question->setOptions($options);

        $this->tester->assertEquals($options, $question->getOptions());
        $this->tester->assertEquals('A', $question->getDefault());

        $question->setDefault('default');
        $this->tester->assertEquals('default', $question->getDefault());

        $question->setWarning('warning');
        $this->tester->assertContains('message: <fg=yellow>warning</>', $question->getMessage());

    }


}