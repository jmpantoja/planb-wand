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

use PlanB\Utils\Dev\Tdd\Test\Data\Data;
use PlanB\Utils\Dev\Tdd\Test\Data\Provider;
use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Logger\LogFormat;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\LogMessage;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class LogManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\LogFormat
 */
class LogFormatTest extends Unit
{

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
     */
    public function testInfo()
    {
        $format = LogFormat::info();

        $title = $format->title('title');
        $this->assertContains('<fg=default>title</>', $title[0]);

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
     * @covers ::addTabs
     * @covers ::toLines
     */
    public function testSuccess()
    {
        $format = LogFormat::success();

        $title = $format->title('title');
        $this->assertContains('<fg=green>title</>', $title[0]);
        $this->assertContains('<fg=green>OK</>', $title[0]);

        $verbose = $format->verbose([
            'A' => 'simple',
            'B' => "line1\nline2\nline3\n"
        ]);

        $this->assertContains('<fg=green>A:</> simple', $verbose[0]);
        $this->assertContains('<fg=green>B:</>', $verbose[1]);

        $this->assertContains('line1', $verbose[2]);
        $this->assertContains('line2', $verbose[3]);
        $this->assertContains('line3', $verbose[4]);


        $bigTitle = $format->title(str_repeat('X', LogFormat::PADDING_LENGTH - 1));
        $this->assertContains('<fg=green>XXXXXXXXXXXXXXX', $bigTitle[0]);
        $this->assertContains('<fg=green>OK</>', $bigTitle[0]);
        $this->assertContains('.', $bigTitle[0]);


        $bigTitle = $format->title(str_repeat('X', LogFormat::PADDING_LENGTH));
        $this->assertContains('<fg=green>XXXXXXXXXXXXXXX', $bigTitle[0]);
        $this->assertContains('<fg=green>OK</>', $bigTitle[0]);
        $this->assertNotContains('.', $bigTitle[0]);

        $bigTitle = $format->title(str_repeat('X', LogFormat::PADDING_LENGTH + 1));
        $this->assertContains('<fg=green>XXXXXXXXXXXXXXX', $bigTitle[0]);
        $this->assertContains('<fg=green>OK</>', $bigTitle[0]);
        $this->assertNotContains('.', $bigTitle[0]);
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
     * @covers ::addTabs
     * @covers ::toLines
     */
    public function testSkip()
    {
        $format = LogFormat::skip();

        $title = $format->title('title');
        $this->assertContains('<fg=yellow>title</>', $title[0]);
        $this->assertContains('<fg=yellow>SKIP</>', $title[0]);

        $verbose = $format->verbose([
            'A' => 'simple',
            'B' => "line1\nline2\nline3\n"
        ]);

        $this->assertContains('<fg=yellow>A:</> simple', $verbose[0]);
        $this->assertContains('<fg=yellow>B:</>', $verbose[1]);

        $this->assertContains('line1', $verbose[2]);
        $this->assertContains('line2', $verbose[3]);
        $this->assertContains('line3', $verbose[4]);
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
     * @covers ::addTabs
     * @covers ::toLines
     */
    public function testError()
    {
        $format = LogFormat::error();

        $title = $format->title('title');
        $this->assertContains('<fg=red>title</>', $title[0]);
        $this->assertContains('<fg=red>ERROR</>', $title[0]);

        $verbose = $format->verbose([
            'A' => 'simple',
            'B' => "line1\nline2\nline3\n"
        ]);

        $this->assertContains('<fg=red>A:</> simple', $verbose[0]);
        $this->assertContains('<fg=red>B:</>', $verbose[1]);

        $this->assertContains('line1', $verbose[2]);
        $this->assertContains('line2', $verbose[3]);
        $this->assertContains('line3', $verbose[4]);
    }
}