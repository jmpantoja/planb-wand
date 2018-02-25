<?php

namespace PlanB\Wand\Core\Context;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property\PackageDescriptionProperty;
use PlanB\Wand\Core\Context\Property\PackageNameProperty;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\Filesystem\Filesystem;
use \Mockery as m;

/**
 * ComposerInfo Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\ComposerInfo
 */
class ComposerInfoTest extends Unit
{

    use Mocker;

    /** @var
     * \UnitTester $tester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::load
     * @covers ::optimize
     * @covers ::save
     *
     */
    public function testUnnecessarySave()
    {
        $composer = realpath(__DIR__ . '/dummy/optimized/composer.json');

        $pathManager = $this->stub(PathManager::class, [
            'composerJsonPath' => $composer
        ]);

        $this->stub(Filesystem::class)
            ->expects()
            ->dumpFile(m::any(), m::any())
            ->never();

        $manager = new ComposerInfo($pathManager);
        $manager->save();

    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::load
     * @covers ::populateSortedKeys
     * @covers ::optimize
     * @covers ::save
     *
     */
    public function testLoad()
    {
        $composer = realpath(__DIR__ . '/dummy/empty/composer.json');

        $pathManager = $this->stub(PathManager::class, [
            'composerJsonPath' => $composer
        ]);

        $this->stub(Filesystem::class)
            ->expects()
            ->dumpFile(m::any(), m::any())
            ->once();

        $target = new ComposerInfo($pathManager);

        $this->assertAttributeEquals([
            'name',
            'description',
            'version',
            'type',
            'keywords',
            'homepage',
            'license',
            'authors',
            'support',
            'require',
            'require-dev',
            'conflict',
            'replace',
            'provide',
            'suggest',
            'autoload',
            'autoload-dev',
            'autoload-dev',
            'minimum-stability',
            'prefer-stable',
            'config',
            'scripts',
            'extra',
            'bin',
            'repositories',

        ], 'keyOrder', $target);
    }


    /**
     * @test
     * @dataProvider providerAccessor
     *
     * @covers ::__construct
     * @covers ::load
     * @covers ::populateSortedKeys
     * @covers ::optimize
     * @covers ::has
     * @covers ::get
     * @covers ::set
     *
     * @covers ::save
     * @covers ::dumpFile
     * @covers ::getSortedValues
     *
     */
    public function testAccessor(Data $data)
    {

        $pathManager = $data->pathManager;
        $property = $data->property;
        $path = $data->path;

        $this->stub(Filesystem::class)
            ->expects()
            ->dumpFile(m::any(), m::any())
            ->twice();

        $target = new ComposerInfo($pathManager);

        $this->tester->assertFalse($target->has($property));

        $target->set($property->getPath(), $path);
        $this->tester->assertTrue($target->has($property));
        $this->tester->assertEquals($path, $target->get($property->getPath()));


        $this->tester->assertTrue($target->get('[config][optimize-autoloader]'));
        $this->tester->assertTrue($target->get('[config][sort-packages]'));
        $this->tester->assertTrue($target->get('[config][apcu-autoloader]'));

        $target->save();

    }

    public function providerAccessor()
    {
        $composer = realpath(__DIR__ . '/dummy/empty/composer.json');

        $pathManager = $this->stub(PathManager::class, [
            'composerJsonPath' => $composer
        ]);

        return Provider::create()
            ->add([
                'path'=>'package/name',
                'property'=>PackageNameProperty::create(),
                'pathManager'=>$pathManager
            ])
            ->end();

        return [
            [PackageNameProperty::create(), 'package/name'],
            [PackageDescriptionProperty::create(), 'package description']
        ];
    }


}