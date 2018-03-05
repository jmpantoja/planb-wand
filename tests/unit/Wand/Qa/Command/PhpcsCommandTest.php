<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Qa\Command;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Context;
use Mockery as m;
use PlanB\Wand\Legacy\Phpcs\CodeSniffer;
use PlanB\Wand\Legacy\Phpcs\SnifferInterface;

/**
 * Class LicenseTest
 * @package PlanB\Wand\ProjectInfo
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass PlanB\Wand\Qa\Command\PhpcsCommand
 */
class PhpcsCommandTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::runMethod
     * @covers ::run
     * @covers ::getTokens
     * @covers ::getRunner
     * @covers ::setRunner
     */
    public function testRun()
    {

        $runner = $this->stub(CodeSniffer::class);

        $runner->expects()
            ->runPHPCBF(m::any())
            ->never();

        $runner->expects()
            ->runPHPCS(m::any())
            ->once()
            ->andReturn(0);


        $context = $this->getContext();
        $command = $this->stub(PhpcsCommand::class, [
            'initialize' => null
        ]);

        $command->setContext($context);
        $this->tester->assertInstanceOf(CodeSniffer::class, $command->getRunner());

        $command->setRunner($runner);
        $this->tester->assertEquals($runner, $command->getRunner());

        $command->run();
    }

    /**
     * @return m\MockInterface
     */
    protected function getContext(): m\MockInterface
    {
        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath(m::anyOf('wand', 'project', 'target'))
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('src')
            ->andReturn(realpath('.') . '/src');

        return $context;
    }


}