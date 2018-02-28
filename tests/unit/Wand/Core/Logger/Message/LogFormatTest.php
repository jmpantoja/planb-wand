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
 * Class LogManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Message\LogFormat
 */
class LogFormatTest extends Unit
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
     * @covers ::info
     * @covers ::title
     * @covers ::format
     * @covers ::getPoints
     * @covers ::colorize
     *
     * @covers ::verbose
     * @covers ::formatVerbose
     *
     * @covers ::getType
     */
    public function testInfo()
    {
        $format = LogFormat::info();

        $title = $format->title('title');
        $this->tester->assertContains('<fg=default>title</>', $title[0]);

        $this->tester->assertTrue($format->getType()->isInfo());
    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::success
     * @covers ::title
     * @covers ::format
     * @covers ::getPoints
     * @covers ::colorize
     *
     * @covers ::verbose
     * @covers ::formatVerbose
     * @covers ::toLines
     *
     * @covers ::getType
     */
    public function testSuccess()
    {
        $format = LogFormat::success();

        $title = $format->title('title');
        $this->tester->assertContains('<fg=green>title</>', $title[0]);
        $this->tester->assertContains('<fg=green>OK</>', $title[0]);

        $verbose = $format->verbose([
            'A' => 'simple',
            'B' => "line1\nline2\nline3\n"
        ]);

        $this->tester->assertContains('<fg=green>A:</> simple', $verbose[0]);
        $this->tester->assertContains('<fg=green>B:</>', $verbose[2]);


        $this->tester->assertContains('line1', $verbose[3]);
        $this->tester->assertContains('line2', $verbose[4]);
        $this->tester->assertContains('line3', $verbose[5]);

        $bigTitle = $format->title(str_repeat('X', LogFormat::PADDING_LENGTH - 1));
        $this->tester->assertContains('<fg=green>XXXXXXXXXXXXXXX', $bigTitle[0]);
        $this->tester->assertContains('<fg=green>OK</>', $bigTitle[0]);
        $this->tester->assertContains('.', $bigTitle[0]);

        $bigTitle = $format->title(str_repeat('X', LogFormat::PADDING_LENGTH));
        $this->tester->assertContains('<fg=green>XXXXXXXXXXXXXXX', $bigTitle[0]);
        $this->tester->assertContains('<fg=green>OK</>', $bigTitle[0]);
        $this->tester->assertNotContains('.', $bigTitle[0]);

        $bigTitle = $format->title(str_repeat('X', LogFormat::PADDING_LENGTH + 1));
        $this->tester->assertContains('<fg=green>XXXXXXXXXXXXXXX', $bigTitle[0]);
        $this->tester->assertContains('<fg=green>OK</>', $bigTitle[0]);
        $this->tester->assertNotContains('.', $bigTitle[0]);

        $this->tester->assertTrue($format->getType()->isSuccessful());
    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::skip
     * @covers ::title
     * @covers ::format
     * @covers ::getPoints
     * @covers ::colorize
     *
     * @covers ::verbose
     * @covers ::formatVerbose
     * @covers ::toLines
     *
     * @covers ::getType
     */
    public function testSkip()
    {
        $format = LogFormat::skip();

        $title = $format->title('title');
        $this->tester->assertContains('<fg=yellow>title</>', $title[0]);
        $this->tester->assertContains('<fg=yellow>SKIP</>', $title[0]);

        $verbose = $format->verbose([
            'A' => 'simple',
            'B' => "line1\nline2\nline3\n"
        ]);

        $this->tester->assertContains('<fg=yellow>A:</> simple', $verbose[0]);
        $this->tester->assertContains('<fg=yellow>B:</>', $verbose[2]);

        $this->tester->assertContains('line1', $verbose[3]);
        $this->tester->assertContains('line2', $verbose[4]);
        $this->tester->assertContains('line3', $verbose[5]);

        $this->tester->assertTrue($format->getType()->isSkipped());
    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::error
     * @covers ::title
     * @covers ::format
     * @covers ::getPoints
     * @covers ::colorize
     *
     * @covers ::verbose
     * @covers ::formatVerbose
     * @covers ::toLines
     *
     * @covers ::getType
     */
    public function testError()
    {
        $format = LogFormat::error();

        $title = $format->title('title');
        $this->tester->assertContains('<fg=red>title</>', $title[0]);
        $this->tester->assertContains('<fg=red>ERROR</>', $title[0]);

        $verbose = $format->verbose([
            'A' => 'simple',
            'B' => "line1\nline2\nline3\n"
        ]);

        $this->tester->assertContains('<fg=red>A:</> simple', $verbose[0]);
        $this->tester->assertContains('<fg=red>B:</>', $verbose[2]);

        $this->tester->assertContains('line1', $verbose[3]);
        $this->tester->assertContains('line2', $verbose[4]);
        $this->tester->assertContains('line3', $verbose[5]);

        $this->tester->assertTrue($format->getType()->isError());
    }
}