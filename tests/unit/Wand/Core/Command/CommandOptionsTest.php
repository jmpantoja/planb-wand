<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Command;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Class CommandText
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Core\Command\CommandOptions
 */
class CommandOptionsTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::configure
     * @covers ::defineGroup
     * @covers ::definePattern
     * @covers ::defineCwd
     */
    public function testResolve()
    {
        $options = [
            'group' => 'el grupo',
            'pattern' => 'el pattern',
            'cwd' => 'vendor/bin'
        ];

        $params = CommandOptions::create()
            ->resolve($options);

        $this->tester->assertEquals($options, $params);
    }


    /**
     * @test
     *
     * @dataProvider providerResolveException
     *
     * @covers ::configure
     * @covers ::defineGroup
     * @covers ::definePattern
     * @covers ::defineCwd
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidArgumentException
     */
    public function testResolveException(Data $data)
    {
        CommandOptions::create()
            ->resolve($data->options);

    }


    public function providerResolveException()
    {
        return Provider::create()
            ->add([
                'options' => [
                    'group' => 'el grupo',
                    'pattern' => 'el pattern',
                    'cwd' => 'bad cwd'
                ]
            ], 'bad cwd')
            ->add([
                'options' => [
                    'pattern' => 'el pattern',
                    'cwd' => 'vendor/bin'
                ]
            ], 'missing group')
            ->add([
                'options' => [
                    'group' => 'el grupo',
                    'cwd' => 'vendor/bin'
                ]
            ], 'missing pattern')
            ->end();
    }

}