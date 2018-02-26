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
     * @covers ::initialize
     * @covers ::populateSortedKeys
     * @covers ::optimize
     *
     * @covers ::save
     *
     */
    public function testUnnecessarySave()
    {
        $pathManager = $this->getPathManager('optimized');

        $this->stub(Filesystem::class)
            ->expects()
            ->dumpFile(m::any(), m::any())
            ->never();

        $manager = ComposerInfo::load($pathManager);
        $manager->save();

    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::load
     * @covers ::initialize
     * @covers ::populateSortedKeys
     * @covers ::optimize
     *
     * @covers ::save
     *
     */
    public function testLoad()
    {
        $pathManager = $this->getPathManager('empty');

        $this->stub(Filesystem::class)
            ->expects()
            ->dumpFile(m::any(), m::any())
            ->once();

        $target = ComposerInfo::load($pathManager);

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
     * @covers ::initialize
     * @covers ::populateSortedKeys
     * @covers ::optimize
     *
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

        $target = ComposerInfo::load($pathManager);

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

        $pathManager = $this->getPathManager('empty');
        return Provider::create()
            ->add([
                'path' => 'package/name',
                'property' => PackageNameProperty::create(),
                'pathManager' => $pathManager
            ])
            ->add([
                'path' => 'package/description',
                'property' => PackageDescriptionProperty::create(),
                'pathManager' => $pathManager
            ])
            ->end();
    }


    private function getPathManager(string $composer): PathManager
    {

        $path = realpath(sprintf('%s/dummy/%s/composer.json', __DIR__, $composer));

        $pathManager = $this->stub(PathManager::class, [
            'composerJsonPath' => $path
        ]);

        return $pathManager;
    }

}