<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Git\File;


use AspectMock\Test;
use Codeception\Test\Unit;

use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\File\File;

/**
 * Class GitIgnoreFileTest
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 * @coversDefaultClass \PlanB\Wand\Git\File\GitIgnoreFile
 */
class GitIgnoreFileTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @dataProvider providerExists
     *
     * @covers ::exists
     */
    public function testExists(Data $data)
    {

        Test::func(__NAMESPACE__, 'file_get_contents', $data->content);

        $this->double(File::class, [
            'exists' => $data->exists,
            'getPath' => realpath('.')
        ]);


        $file = GitIgnoreFile::create([
            'group' => 'grupo',
            'params' => [
                'target' => '.gitignore',
                'template' => ''
            ]
        ]);

        $this->tester->assertEquals($data->expected, $file->exists());
    }

    public function providerExists()
    {
        return Provider::create()
            ->add([
                'exists' => false,
                'content' => 'da igual',
                'expected' => false,
            ], 'el archivo no existe')
            ->add([
                'exists' => true,
                'content' => $this->getContent('.wand-cache'),
                'expected' => true,
            ], 'el archivo existe, y contiene una referencia a .wand-cache')
            ->add([
                'exists' => true,
                'content' => $this->getContent(),
                'expected' => false,
            ], 'el archivo existe, pero no contiene una referencia a .wand-cache')
            ->end();
    }

    private function getContent(?string $line = null)
    {
        return implode("\n", [
            '.env',
            '/public/bundles/',
            '/var/',
            '/vendor/',
            '/bin/*',
            '!bin/.gitkeep',
            '!bin/console',
            '/build/',
            '!build/.gitkeep',
            '!var/.gitkeep',
            '!var/*/.gitkeep',
            '/var/bootstrap.php.cache',
            '/tests/_output/',
            '!tests/_output/.gitkeep',
            '.phplint-cache',
            $line,
            '.idea/',
            '/phpunit.xml'
        ]);
    }
}