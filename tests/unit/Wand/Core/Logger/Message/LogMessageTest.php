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


/**
 * Class LogMessageTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Message\LogMessage
 */
class LogMessageTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::setTitle
     * @covers ::setVerbose
     *
     * @covers ::info
     * @covers ::parse
     * @covers ::parseVerbose
     * @covers ::isInfo
     * @covers ::getType
     */
    public function testInfo()
    {
        $message = LogMessage::info()
            ->setTitle('title');

        $normal = $message->parse();
        $this->assertContains('<fg=default>title</>', $normal[0]);

        $verbose = $message->parseVerbose();
        $this->assertContains('<fg=default>title</>', $verbose[0]);

        $this->assertTrue($message->isInfo());
        $this->assertTrue($message->getType()->isInfo());

    }

    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::setTitle
     * @covers ::setVerbose
     * @covers ::addVerbose
     *
     * @covers ::success
     * @covers ::parse
     * @covers ::parseVerbose
     * @covers ::isSuccessful
     * @covers ::getType
     */
    public function testSuccess()
    {
        $message = LogMessage::success()
            ->setTitle('title')
            ->setVerbose([
                'A' => 'simple',
                'B' => "line1\nline2\nline3\nline4"
            ])
            ->addVerbose('extra', 'simple');

        $normal = $message->parse();
        $this->assertContains('<fg=green>title</>', $normal[0]);
        $this->assertContains('<fg=green>OK</>', $normal[0]);

        $verbose = $message->parseVerbose();
        $this->assertContains('<fg=green>title</>', $verbose[0]);
        $this->assertContains('<fg=green>OK</>', $verbose[0]);
        $this->assertContains('<fg=green>A:</> simple', $verbose[1]);
        $this->assertContains('<fg=green>B:</>', $verbose[2]);
        $this->assertContains('line1', $verbose[3]);
        $this->assertContains('line2', $verbose[4]);
        $this->assertContains('line3', $verbose[5]);
        $this->assertContains('line4', $verbose[6]);
        $this->assertContains('<fg=green>EXTRA:</> simple', $verbose[7]);

        $this->assertTrue($message->isSuccessful());
        $this->assertTrue($message->getType()->isSuccessful());
    }


    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::setTitle
     * @covers ::setVerbose
     * @covers ::addVerbose
     *
     * @covers ::skip
     * @covers ::parse
     * @covers ::parseVerbose
     * @covers ::isSkipped
     * @covers ::getType
     */
    public function testSkip()
    {
        $message = LogMessage::skip()
            ->setTitle('title')
            ->setVerbose([
                'A' => 'simple',
                'B' => "line1\nline2\nline3\nline4"
            ])
            ->addVerbose('extra', 'simple');;

        $normal = $message->parse();
        $this->assertContains('<fg=yellow>title</>', $normal[0]);
        $this->assertContains('<fg=yellow>SKIP</>', $normal[0]);

        $verbose = $message->parseVerbose();
        $this->assertContains('<fg=yellow>title</>', $verbose[0]);
        $this->assertContains('<fg=yellow>SKIP</>', $verbose[0]);
        $this->assertContains('<fg=yellow>A:</> simple', $verbose[1]);
        $this->assertContains('<fg=yellow>B:</>', $verbose[2]);
        $this->assertContains('line1', $verbose[3]);
        $this->assertContains('line2', $verbose[4]);
        $this->assertContains('line3', $verbose[5]);
        $this->assertContains('line4', $verbose[6]);
        $this->assertContains('<fg=yellow>EXTRA:</> simple', $verbose[7]);

        $this->assertTrue($message->isSkipped());
        $this->assertTrue($message->getType()->isSkipped());
    }

    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::setTitle
     * @covers ::setVerbose
     * @covers ::addVerbose
     *
     * @covers ::error
     * @covers ::parse
     * @covers ::parseVerbose
     * @covers ::isError
     * @covers ::getType
     */
    public function testError()
    {

        $message = LogMessage::error()
            ->setTitle('title')
            ->setVerbose([
                'A' => 'simple',
                'B' => "line1\nline2\nline3\nline4"
            ])
            ->addVerbose('extra', 'simple');;

        $normal = $message->parse();
        $this->assertContains('<fg=red>title</>', $normal[0]);
        $this->assertContains('<fg=red>ERROR</>', $normal[0]);

        $verbose = $message->parseVerbose();
        $this->assertContains('<fg=red>title</>', $verbose[0]);
        $this->assertContains('<fg=red>ERROR</>', $verbose[0]);
        $this->assertContains('<fg=red>A:</> simple', $verbose[1]);
        $this->assertContains('<fg=red>B:</>', $verbose[2]);
        $this->assertContains('line1', $verbose[3]);
        $this->assertContains('line2', $verbose[4]);
        $this->assertContains('line3', $verbose[5]);
        $this->assertContains('line4', $verbose[6]);
        $this->assertContains('<fg=red>EXTRA:</> simple', $verbose[7]);

        $this->assertTrue($message->isError());
        $this->assertTrue($message->getType()->isError());

    }

}