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

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Logger\Message\LogMessage;
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

        $this->assertInstanceOf(QuestionMessage::class, $question);
        $this->assertEquals('message', $question->getMessage());

        $this->assertInternalType('callable', $question->getValidator());
        $this->assertInternalType('callable', $question->getNormalizer());

        $this->assertFalse($question->hasOptions());


        $options = ['A', 'B', 'C'];
        $question->setOptions($options);

        $this->assertEquals($options, $question->getOptions());
        $this->assertEquals('A', $question->getDefault());

        $question->setDefault('default');
        $this->assertEquals('default', $question->getDefault());

        $question->setWarning('warning');
        $this->assertContains('message: <fg=yellow>warning</>', $question->getMessage());

    }


}