<?php

namespace PlanB\Wand\Core\Context;

use PlanB\Wand\Core\Context\Property\PackageDescriptionProperty;
use PlanB\Wand\Core\Context\Property\PackageNameProperty;
use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * ComposerInfo Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\ComposerInfo
 */
class ComposerInfoTest extends Unit
{

    /**
     * @test
     * @dataProvider providerAccessor
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

        $pathManager = $this->make(PathManager::class, [
            'composerJsonPath' => $composer
        ]);

        $fileSystem = $this->mock(Filesystem::class);

        $manager = new ComposerInfo($pathManager);
        $manager->save();

        $fileSystem->verify('dumpFile', 0);
    }

    /**
     * @test
     * @dataProvider providerAccessor
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
        $composer = realpath(__DIR__ . '/dummy/incomplete/composer.json');

        $pathManager = $this->make(PathManager::class, [
            'composerJsonPath' => $composer
        ]);

        $this->mock(Filesystem::class, [
            'dumpFile' => null
        ]);


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
    public function testAccessor(Property $property, $expected)
    {

        $composer = realpath(__DIR__ . '/dummy/incomplete/composer.json');

        $pathManager = $this->make(PathManager::class, [
            'composerJsonPath' => $composer
        ]);

        $fileSystem = $this->mock(Filesystem::class, [
            'dumpFile' => null
        ]);


        $target = new ComposerInfo($pathManager);


        $this->assertFalse($target->has($property));

        $target->set($property->getPath(), $expected);

        $this->assertTrue($target->has($property));

        $this->assertEquals($expected, $target->get($property->getPath()));

        $this->assertTrue($target->get('[config][optimize-autoloader]'));
        $this->assertTrue($target->get('[config][sort-packages]'));
        $this->assertTrue($target->get('[config][apcu-autoloader]'));

        $target->save();

        $fileSystem->verify('dumpFile', 2, [$composer]);
    }

    public function providerAccessor()
    {
        return [
            [PackageNameProperty::create(), 'package/name'],
            [PackageDescriptionProperty::create(), 'package description']
        ];
    }


}