<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Git;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use Symfony\Component\Process\Process;
use Mockery as m;

/**
 * Class GitManagerTest
 * @package PlanB\Wand\Core\Git
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Git\GitManager
 */
class GitManagerTest extends Unit
{
    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;


    /**
     * @test
     * @dataProvider providerInitialized
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::isInitialized
     */
    public function testInitialized(Data $data)
    {

        $manager = GitManager::create($data->base);

        $this->tester->assertEquals($data->initialized, $manager->isInitialized());
    }

    public function providerInitialized()
    {
        $base = realpath('.');
        return Provider::create()
            ->add([
                'base' => $base,
                'initialized' => true
            ], 'directorio raiz')
            ->add([
                'base' => "$base/src",
                'initialized' => true
            ], 'subdirectorio')
            ->add([
                'base' => "/tmp",
                'initialized' => false
            ], 'otra cosa')
            ->end();
    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::hasStagedFiles
     * @covers ::getStagedFiles
     * @covers ::verifyFile
     * @covers ::setWhiteList
     *
     * @covers ::run
     */
    public function testStageFiles()
    {

        $this->stub(Process::class, [
            'run' => 0,
            'getOutput' => "\n\nsrc/FileA.php\n\nsrc/FileB.txt\n\nsrc/FileC.php\n\nsrc/FileD.php\n\n"
        ]);

        $manager = GitManager::create(realpath('.'));

        $this->tester->assertTrue($manager->hasStagedFiles());

        $files = $manager->getStagedFiles();
        $this->assertEquals([
            'src/FileA.php',
            'src/FileC.php',
            'src/FileD.php',
        ], $files);



        $manager->setWhiteList([
            'src/FileA.php',
            'src/FileD.php',
        ]);

        $files = $manager->getStagedFiles();
        $this->assertEquals([
            'src/FileA.php',
            'src/FileD.php',
        ], $files);


        $manager->setWhiteList(null);
        $files = $manager->getStagedFiles();
        $this->assertEquals([
            'src/FileA.php',
            'src/FileC.php',
            'src/FileD.php',
        ], $files);
    }


    /**
     * @test
     *
     * @covers ::reStageFiles
     * @covers ::gitAdd
     */
    public function testRestage()
    {

        $response = $this->getResponse(true);

        $manager = $this->stub(GitManager::class, [
            'getStagedFiles' => [
                'src/FileA.php',
                'src/FileC.php',
                'src/FileD.php',
            ]
        ]);

        $manager->allows()
            ->run(m::anyOf('git add src/FileA.php',
                'git add src/FileC.php',
                'git add src/FileD.php'))
            ->times(3)
            ->andReturn($response);

        $manager->reStageFiles();
    }

    /**
     * @test
     * @dataProvider providerCommandLine
     *
     * @covers ::getCommandLine
     */
    public function testCommandLine(Data $data)
    {

        $response = $this->getResponse($data->success);
        $response->allows()
            ->getOutput()
            ->andReturn("\n\nsrc/FileA.php\n\nsrc/FileB.txt\n\nsrc/FileC.php\n\nsrc/FileD.php\n\n");


        $manager = $this->stub(GitManager::class);

        $manager->allows()
            ->run('git rev-parse --verify HEAD')
            ->andReturn($response);

        $manager->expects()
            ->run($data->expected)
            ->once()
            ->andReturn($response);

        $this->assertEquals([
            'src/FileA.php',
            'src/FileC.php',
            'src/FileD.php',
        ], $manager->getStagedFiles());
    }

    public function providerCommandLine()
    {
        return Provider::create()
            ->add([
                'success' => true,
                'expected' => "git diff-index --cached --name-status HEAD | egrep '^(A|M)' | awk '{print $2;}'"
            ])
            ->add([
                'success' => false,
                'expected' => "git diff-index --cached --name-status 4b825dc642cb6eb9a060e54bf8d69288fbee4904 | egrep '^(A|M)' | awk '{print $2;}'"
            ])
            ->end();
    }

    /**
     * @param bool $success
     * @return m\MockInterface
     */
    protected function getResponse(bool $success): m\MockInterface
    {
        $response = $this->stub(Process::class, [
            'isSuccessful' => $success
        ]);
        return $response;
    }


}