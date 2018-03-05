<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Info\File;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Context;
use Symfony\Component\Process\Process;

/**
 * Class LicenseTest
 * @package PlanB\Wand\ProjectInfo
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass PlanB\Wand\Info\File\License
 */
class LicenseTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     * @dataProvider providerCreate
     *
     * @covers ::create
     *
     * @covers ::getTemplate
     * @covers ::getProfile
     */
    public function testCreate(Data $data)
    {
        $file = $this->getFile($data);
        $this->tester->assertEquals($data->expected, $file->getTemplate());
        $this->tester->assertEquals('without-template', $file->getProfile());
    }


    public function providerCreate()
    {
        return Provider::create()
            ->add([
                'template' => 'MIT',
                'expected' => '@wand.projectInfo/license/mit.twig'
            ])
            ->add([
                'template' => 'Apache-2.0',
                'expected' => '@wand.projectInfo/license/apache-2.0.twig'
            ])
            ->add([
                'template' => 'Unlicense',
                'expected' => '@wand.projectInfo/license/unlicense.twig'
            ])
            ->end();
    }

    private function getFile(Data $data): \PlanB\Wand\Core\File\File
    {
        $context = $this->stub(Context::class);

        $context->allows()
            ->getParam('license')
            ->andReturn($data->template);

        $file = License::create([
            'group' => 'projectInfo',
            'params' => [
                'target' => 'LICENSE',
                'action' => 'create'
            ]
        ]);

        $file->setContext($context);
        return $file;
    }
}