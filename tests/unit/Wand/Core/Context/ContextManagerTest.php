<?php

namespace PlanB\Wand\Core\Context;


use PlanB\Utils\Dev\Tdd\Test\Data\Data;
use PlanB\Utils\Dev\Tdd\Test\Data\Provider;
use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Filesystem;

/**
 * ComposerInfo Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\ContextManager
 */
class ContextManagerTest extends Unit
{

    /**
     * @test
     *
     * @dataProvider providerExecute
     *
     * @covers ::__construct
     * @covers ::getSubscribedEvents
     * @covers ::toArray
     * @covers ::execute
     * @covers ::resolve
     * @covers ::read
     * @covers ::ask
     *
     */
    public function testExecute(Data $data)
    {
        $responses = $data->responses;
        $expected = $data->expected;
        $fileName = $data->fileName;

        $logger = $this->getLogger($responses);
        $info = $this->getInfo($fileName);

        $manager = new ContextManager($logger, $info);

        $this->assertEquals($expected, $manager->toArray());

        $this->assertArrayHasKey('wand.context.execute', ContextManager::getSubscribedEvents());
    }

    public function providerExecute()
    {

        return Provider::create()
            ->add([
                'fileName' => realpath(__DIR__ . '/dummy/incomplete/composer.json'),
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

    /**
     * @return mixed|\PlanB\Utils\Dev\Tdd\Mock\Proxy\ProxyInterface
     */
    protected function getLogger($responses)
    {
        $logger = $this->make(LogManager::class, [
            'info' => null,
            'question' => function (QuestionMessage $question) use ($responses) {
                $message = $question->getMessage();

                $pieces = explode(':', $message);
                $message = trim($pieces[0]);

                return $responses[$message];

            }
        ]);
        return $logger;
    }

    private function getInfo($fileName)
    {
        $this->make(Filesystem::class, [
            'dumpFile' => null
        ]);

        $pathManager = $this->make(PathManager::class, [
            'composerJsonPath' => $fileName
        ]);

        return new ComposerInfo($pathManager);
    }


}