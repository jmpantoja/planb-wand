<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Path;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Logger\Confirm\ConfirmEvent;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Logger\Message\MessageEvent;
use PlanB\Wand\Core\Logger\Question\QuestionEvent;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;
use Symfony\Component\EventDispatcher\EventDispatcher;


/**
 * Class LogManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\LogManager
 */
class LogManagerTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     * @covers ::__construct
     * @covers ::info
     * @covers ::message
     */
    public function testInfo()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.message', function ($event) {

            $this->tester->assertInstanceOf(MessageEvent::class, $event);
            $this->tester->assertTrue($event->getMessage()->isInfo());

            $lines = $event->getMessage()->parse();
            $this->tester->assertContains('<fg=default>message</>', $lines[0]);

        });

        $logger = new LogManager($dispatcher);
        $logger->info('message');
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::success
     * @covers ::message
     */
    public function testSuccess()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.message', function ($event) {

            $this->tester->assertInstanceOf(MessageEvent::class, $event);
            $this->tester->assertTrue($event->getMessage()->isSuccessful());

            $lines = $event->getMessage()->parse();
            $this->tester->assertContains('<fg=green>message</>', $lines[0]);

        });

        $logger = new LogManager($dispatcher);
        $logger->success('message');
    }


    /**
     * @test
     * @covers ::__construct
     * @covers ::skip
     * @covers ::message
     */
    public function testSkip()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.message', function ($event) {

            $this->tester->assertInstanceOf(MessageEvent::class, $event);
            $this->tester->assertTrue($event->getMessage()->isSkipped());

            $lines = $event->getMessage()->parse();
            $this->tester->assertContains('<fg=yellow>message</>', $lines[0]);

        });

        $logger = new LogManager($dispatcher);
        $logger->skip('message');
    }


    /**
     * @test
     * @covers ::__construct
     * @covers ::error
     * @covers ::message
     */
    public function testError()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.message', function ($event) {

            $this->tester->assertInstanceOf(MessageEvent::class, $event);
            $this->tester->assertTrue($event->getMessage()->isError());

            $lines = $event->getMessage()->parse();
            $this->tester->assertContains('<fg=red>message</>', $lines[0]);

        });

        $logger = new LogManager($dispatcher);
        $logger->error('message');

    }


    /**
     * @test
     * @covers ::__construct
     * @covers ::log
     * @covers ::message
     */
    public function testLog()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.message', function ($event) {

            $this->tester->assertInstanceOf(MessageEvent::class, $event);
            $this->tester->assertTrue($event->getMessage()->isInfo());

            $lines = $event->getMessage()->parse();

            $this->tester->assertContains('<fg=default>message</>', $lines[0]);

        });

        $event = $this->stub(ActionEvent::class, [
            'getMessage' => LogMessage::info()
                ->setTitle('message')
        ]);

        $logger = new LogManager($dispatcher);
        $logger->log($event);
    }


    /**
     * @test
     * @covers ::__construct
     * @covers ::question
     * @covers ::message
     */
    public function testQuestion()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.question', function ($event) {

            $this->tester->assertInstanceOf(QuestionEvent::class, $event);
            $event->setAnswer('answer');

            $message = $event->getQuestion()->getMessage();
            $this->tester->assertContains('message', $message);

        });

        $logger = new LogManager($dispatcher);
        $logger->question(QuestionMessage::create('message'));
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::confirm
     * @covers ::message
     */
    public function testConfirm()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('wand.log.confirm', function ($event) {

            $this->tester->assertInstanceOf(ConfirmEvent::class, $event);
            $event->setAnswer(true);

            $message = $event->getConfirm()->getMessage();
            $this->tester->assertContains('message (Y / n):', $message);

        });

        $logger = new LogManager($dispatcher);
        $logger->confirm('message');
    }

}