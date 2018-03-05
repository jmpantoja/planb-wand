<?php

namespace PlanB\Wand\Core\Context;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;

use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\Filesystem\Filesystem;

use \Mockery as m;

/**
 * ComposerInfo Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\ContextManager
 */
class ContextManagerTest extends Unit
{


    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @dataProvider providerExecute
     *
     * @covers ::__construct
     *
     * @covers ::getValues
     * @covers ::getContext
     *
     * @covers ::execute
     * @covers ::resolve
     * @covers ::read
     * @covers ::ask
     */
    public function testExecute(Data $data)
    {

        $expected = $data->expected;

        $pathManager = $this->getPathManager($data);
        $logger = $this->stub(LogManager::class, [
            'info' => null
        ]);

        $logger->allows()
            ->question(m::any())
            ->andReturnUsing(function (QuestionMessage $question) use ($data) {

                $responses = $data->responses;

                $message = $question->getMessage();
                $pieces = explode(':', $message);
                $message = trim($pieces[0]);
                return $responses[$message];

            });

        $manager = new ContextManager($logger, $pathManager);
        $context = $manager->getContext();

        $this->tester->assertEquals($expected, $context->getParams());
    }

    public function providerExecute()
    {

        return Provider::create()
            ->add([
                'fileName' => realpath(__DIR__ . '/dummy/empty/composer.json'),
                'responses' => [
                    'Package Name' => 'package/name',
                    'Package Description' => 'package description',
                    'Package Type' => 'project',
                    'License' => 'MIT',
                    'Author Name' => 'pepe botika',
                    'Author Email' => 'pepe@botika.com',
                    'Github Username' => 'https://github.com/botika/'
                ],
                'expected' => [
                    'package_name' => 'package/name',
                    'package_description' => 'package description',
                    'package_type' => 'project',
                    'license' => 'MIT',
                    'author_name' => 'pepe botika',
                    'author_email' => 'pepe@botika.com',
                    'author_homepage' => 'https://github.com/botika/',
                    'github_username' => 'botika',
                ]
            ], 'complete')
            ->add([
                'fileName' => realpath(__DIR__ . '/dummy/partial/composer.json'),
                'responses' => [
                    'Author Name' => 'pepe botika',
                    'Author Email' => 'pepe@botika.com',
                    'Github Username' => 'https://github.com/botika/'
                ],
                'expected' => [
                    'package_name' => 'package/name',
                    'package_description' => 'package description',
                    'package_type' => 'project',
                    'license' => 'MIT',
                    'author_name' => 'pepe botika',
                    'author_email' => 'pepe@botika.com',
                    'author_homepage' => 'https://github.com/botika/',
                    'github_username' => 'botika',
                ]
            ], 'partial')
            ->add([
                'fileName' => realpath(__DIR__ . '/dummy/invalid/composer.json'),
                'responses' => [
                    'Package Name' => 'package/name',
                    'License' => 'MIT',
                    'Author Name' => 'pepe botika',
                    'Author Email' => 'pepe@botika.com',
                    'Github Username' => 'https://github.com/botika/'
                ],
                'expected' => [
                    'package_name' => 'package/name',
                    'package_description' => 'package description',
                    'package_type' => 'project',
                    'license' => 'MIT',
                    'author_name' => 'pepe botika',
                    'author_email' => 'pepe@botika.com',
                    'author_homepage' => 'https://github.com/botika/',
                    'github_username' => 'botika',
                ]
            ], 'partial with errors')
            ->end();
    }

    private function getPathManager(Data $data)
    {
        $fileName = $data->fileName;
        $this->stub(Filesystem::class, [
            'dumpFile' => null
        ]);

        $pathManager = $this->stub(PathManager::class, [
            'composerJsonPath' => $fileName,
            'getPaths' => []
        ]);

        return $pathManager;
    }


}