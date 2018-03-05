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
 * @coversDefaultClass PlanB\Wand\Qa\Command\PhpcbfCommand
 */
class PhpcbfCommandTest extends Unit
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
     */
    public function testRun()
    {

        $runner = $this->stub(CodeSniffer::class);

        $runner->expects()
            ->runPHPCBF(m::any())
            ->once()
            ->andReturn(0);

        $runner->expects()
            ->runPHPCS(m::any())
            ->never();


        $context = $this->getContext();

        $command = $this->stub(PhpcbfCommand::class, [
            'initialize' => null,
            'getRunner' => $runner
        ]);

        $command->setContext($context);
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