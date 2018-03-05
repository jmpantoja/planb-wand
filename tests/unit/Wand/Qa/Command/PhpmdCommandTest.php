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
use Mockery\MockInterface;
use PlanB\Wand\Legacy\Phpcs\SnifferInterface;
use PlanB\Wand\Legacy\Phpmd\CommandPhpmd;


/**
 * Class LicenseTest
 * @package PlanB\Wand\ProjectInfo
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass PlanB\Wand\Qa\Command\PhpmdCommand
 */
class PhpmdCommandTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::run
     */
    public function testRun()
    {
        $context = $this->getContext();

        $phpmd = $this->stub(CommandPhpmd::class, [
            'getOutput' => 'output'
        ]);

        $phpmd->allows()
            ->run(m::any(), m::any())
            ->once()
            ->andReturn(0);

        $command = PhpmdCommand::create([
            'group' => 'qa',
            'params' => [
                'pattern' => 'phpmd %src% text %project%/phpmd.xml --minimumpriority 3'
            ]
        ]);

        $command->setContext($context);

        $this->assertTrue($command->run());

        $this->tester->assertEquals('output', $command->getOutput());
    }

    /**
     * @test
     *
     * @covers ::run
     */
    public function testRunException()
    {
        $context = $this->getContext();

        $phpmd = $this->stub(CommandPhpmd::class);

        $phpmd->allows()
            ->run(m::any(), m::any())
            ->once()
            ->andThrow(new \Exception('error output', 1));

        $command = PhpmdCommand::create([
            'group' => 'qa',
            'params' => [
                'pattern' => 'phpmd %src% text %project%/phpmd.xml --minimumpriority 3'
            ]
        ]);

        $command->setContext($context);

        $this->assertFalse($command->run());


        $this->tester->assertEquals('error output', $command->getOutput());
    }

    /**
     * @return MockInterface
     */
    protected function getContext(): MockInterface
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