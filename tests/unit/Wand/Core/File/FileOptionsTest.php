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

use PlanB\Utils\Dev\Tdd\Test\Data\Data;
use PlanB\Utils\Dev\Tdd\Test\Data\Provider;
use PlanB\Utils\Dev\Tdd\Test\Unit;

/**
 * Class FileOptionsTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\FileOptions
 */
class FileOptionsTest extends Unit
{

    /**
     * @test
     *
     * @covers ::configure
     * @covers ::defineAction
     * @covers ::defineChmod
     * @covers ::defineGroup
     * @covers ::defineTarget
     * @covers ::defineTemplate
     */
    public function testResolveDefaultValues()
    {
        $options = FileOptions::create()
            ->resolve([
                'group' => 'metainfo',
                'target' => 'FILENAME.md',
                'template' => '@wand.metainfo.readme.twig'
            ]);


        $this->assertEquals([
            'action' => 'create',
            'chmod' => 420,
            'group' => 'metainfo',
            'target' => 'FILENAME.md',
            'template' => '@wand.metainfo.readme.twig'
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
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveException(Data $data)
    {

        $values = $data->getArrayCopy();

        $default = [
            'group' => 'metainfo',
            'target' => 'FILENAME.md',
            'template' => '@wand.metainfo.readme.twig'
        ];

        $params = array_replace($default, $values);

        FileOptions::create()
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
                'template' => null
            ], 'bad template')
            ->add([
                'target' => null
            ], 'bad target')
            ->add([
                'group' => null
            ], 'bad group')
            ->add([
                'template' => ['solo admite texto']
            ], 'bad template type')
            ->add([
                'target' => ['solo admite texto']
            ], 'bad target type')
            ->add([
                'group' => ['solo admite texto']
            ], 'bad group type')
            ->end();
    }
}