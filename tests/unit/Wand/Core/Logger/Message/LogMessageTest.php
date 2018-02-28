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

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

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
        $this->tester->assertContains('<fg=default>title</>', $normal[0]);

        $verbose = $message->parseVerbose();
        $this->tester->assertContains('<fg=default>title</>', $verbose[0]);

        $this->tester->assertTrue($message->isInfo());
        $this->tester->assertTrue($message->getType()->isInfo());

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
        $this->tester->assertContains('<fg=green>title</>', $normal[0]);
        $this->tester->assertContains('<fg=green>OK</>', $normal[0]);

        $verbose = $message->parseVerbose();

        $this->tester->assertContains('<fg=green>title</>', $verbose[0]);
        $this->tester->assertContains('<fg=green>OK</>', $verbose[0]);
        $this->tester->assertContains('<fg=green>A:</> simple', $verbose[1]);
        $this->tester->assertContains('<fg=green>B:</>', $verbose[3]);
        $this->tester->assertContains('line1', $verbose[4]);
        $this->tester->assertContains('line2', $verbose[5]);
        $this->tester->assertContains('line3', $verbose[6]);
        $this->tester->assertContains('line4', $verbose[7]);
        $this->tester->assertContains('<fg=green>EXTRA:</> simple', $verbose[9]);

        $this->tester->assertTrue($message->isSuccessful());
        $this->tester->assertTrue($message->getType()->isSuccessful());
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
        $this->tester->assertContains('<fg=yellow>title</>', $normal[0]);
        $this->tester->assertContains('<fg=yellow>SKIP</>', $normal[0]);

        $verbose = $message->parseVerbose();

        $this->tester->assertContains('<fg=yellow>title</>', $verbose[0]);
        $this->tester->assertContains('<fg=yellow>SKIP</>', $verbose[0]);
        $this->tester->assertContains('<fg=yellow>A:</> simple', $verbose[1]);
        $this->tester->assertContains('<fg=yellow>B:</>', $verbose[3]);
        $this->tester->assertContains('line1', $verbose[4]);
        $this->tester->assertContains('line2', $verbose[5]);
        $this->tester->assertContains('line3', $verbose[6]);
        $this->tester->assertContains('line4', $verbose[7]);
        $this->tester->assertContains('<fg=yellow>EXTRA:</> simple', $verbose[9]);

        $this->tester->assertTrue($message->isSkipped());
        $this->tester->assertTrue($message->getType()->isSkipped());
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
            ->addVerbose('extra', 'simple');


        $normal = $message->parse();
        $this->tester->assertContains('<fg=red>title</>', $normal[0]);
        $this->tester->assertContains('<fg=red>ERROR</>', $normal[0]);

        $verbose = $message->parseVerbose();
        $this->tester->assertContains('<fg=red>title</>', $verbose[0]);
        $this->tester->assertContains('<fg=red>ERROR</>', $verbose[0]);
        $this->tester->assertContains('<fg=red>A:</> simple', $verbose[1]);
        $this->tester->assertContains('<fg=red>B:</>', $verbose[3]);
        $this->tester->assertContains('line1', $verbose[4]);
        $this->tester->assertContains('line2', $verbose[5]);
        $this->tester->assertContains('line3', $verbose[6]);
        $this->tester->assertContains('line4', $verbose[7]);
        $this->tester->assertContains('<fg=red>EXTRA:</> simple', $verbose[9]);

        $this->tester->assertTrue($message->isError());
        $this->tester->assertTrue($message->getType()->isError());

    }


    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::setLevel
     * @covers ::addTabs
     */
    public function testLevel()
    {

        $message = LogMessage::info()
            ->setTitle('title')
            ->setVerbose([
                'A' => 'simple',
                'B' => "line1\nline2\nline3\nline4"
            ]);


        $normal = $message->parse();
        $this->tester->assertEquals('<fg=default>title</>', $normal[0]);

        $message->setLevel(1);
        $normal = $message->parse();
        $this->tester->assertEquals('  <fg=default>title</>', $normal[0]);

        $message->setLevel(2);
        $normal = $message->parse();
        $this->tester->assertEquals('    <fg=default>title</>', $normal[0]);


        $this->assertEquals([
            '    <fg=default>title</>',
            '    <fg=default>A:</> simple',
            '    ',
            '    <fg=default>B:</>',
            '    line1',
            '    line2',
            '    line3',
            '    line4',
            '    ',
        ], $message->parseVerbose());


    }


}