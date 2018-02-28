<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;

/**
 * Class FileOptionsTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\FileOptions
 */
class FileOptionsNoTemplateTest extends Unit
{
    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::configure
     * @covers ::defineAction
     * @covers ::defineChmod
     * @covers ::defineGroup
     * @covers ::defineTarget
     */
    public function testResolveDefaultValues()
    {
        $options = FileOptions::create('without-template')
            ->resolve([
                'group' => 'metainfo',
                'target' => 'FILENAME.md'
            ]);


        $this->tester->assertEquals([
            'action' => 'create',
            'chmod' => 420,
            'group' => 'metainfo',
            'target' => 'FILENAME.md'
        ], $options);
    }


    /**
     * @test
     *
     * @dataProvider providerResolveException
     *
     * @covers ::configure
     * @covers ::defineAction
     * @covers ::defineChmod
     * @covers ::defineGroup
     * @covers ::defineTarget
     * @covers ::defineTemplate
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidArgumentException
     */
    public function testResolveException(Data $data)
    {

        $values = $data->getArrayCopy();

        $default = [
            'group' => 'metainfo',
            'target' => 'FILENAME.md'
        ];

        $params = array_replace($default, $values);

        FileOptions::create('without-template')
            ->resolve($params);

    }

    public function providerResolveException()
    {
        return Provider::create()
            ->add([
                'action' => 'distinto a create o remove'
            ], 'bad action')
            ->add([
                'chmod' => 'solo admite enteros'
            ], 'bad chmod')
            ->add([
                'template' => 'no admite templates'
            ], 'bad template')
            ->add([
                'target' => null
            ], 'bad target')
            ->add([
                'group' => null
            ], 'bad group')
            ->add([
                'target' => ['solo admite texto']
            ], 'bad target type')
            ->add([
                'group' => ['solo admite texto']
            ], 'bad group type')
            ->end();
    }
}