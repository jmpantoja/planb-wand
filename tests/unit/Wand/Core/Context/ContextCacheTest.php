<?php

namespace PlanB\Wand\Core\Context;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * ComposerInfo Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\ContextCache
 */
class ContextCacheTest extends Unit
{

    use Mocker;

    /** @var
     * \UnitTester $tester
     */
    protected $tester;

    protected function _before(): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove('/tmp/.wand-cache');
    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::filter
     * @covers ::getLastExecution
     * @covers ::read
     * @covers ::update
     */
    public function testCreate()
    {

        $base = '/tmp';
        $cache = ContextCache::create($base);

        $this->assertAttributeEquals("$base/.wand-cache", 'path', $cache);

        $fileInfo = $this->stub(SplFileInfo::class, [
            'getPathname' => '/path/to/file',
            'getMTime' => 100
        ]);

        $this->assertTrue($cache->filter($fileInfo));
        $cache->update();

        $this->assertFalse($cache->filter($fileInfo));


        $newCache = ContextCache::create($base);
        $modified = $this->stub(SplFileInfo::class, [
            'getPathname' => '/path/to/file',
            'getMTime' => 200
        ]);

        $noModified = $this->stub(SplFileInfo::class, [
            'getPathname' => '/path/to/file',
            'getMTime' => 100
        ]);


        $this->assertFalse($newCache->filter($noModified));


    }


}