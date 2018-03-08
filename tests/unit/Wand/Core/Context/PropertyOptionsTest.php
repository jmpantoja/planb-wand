<?php

namespace PlanB\Wand\Core\Context;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;


/**
 * Options Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\PropertyOptions
 */
class PropertyOptionsTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     *
     * @covers ::configure
     * @covers ::definePath
     * @covers ::defineMessage
     * @covers ::normalizeMessage
     * @covers ::resolve
     *
     */
    public function testCreate()
    {
        /** @var PropertyOptions $target */
        $target = PropertyOptions::create();
        $this->tester->assertInstanceOf(PropertyOptions::class, $target);

        $options = [
            'path' => '[path]',
            'message' => 'message'
        ];

        $params = $target->resolve($options);

        $this->tester->assertEquals('[path]', $params['path']);
        $this->tester->assertEquals('message: ', $params['message']);

    }


    /**
     * @test
     *
     * @dataProvider providerCreate
     *
     * @covers ::configure
     * @covers ::definePath
     * @covers ::defineMessage
     * @covers ::normalizeMessage
     * @covers ::resolve
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidArgumentException
     */
    public function testCreateException(Data $data)
    {
        /** @var PropertyOptions $target */
        $target = PropertyOptions::create();
        $this->tester->assertInstanceOf(PropertyOptions::class, $target);

        $target->resolve($data->options);

    }

    public function providerCreate()
    {

        return Provider::create()
            ->add([
                'options' => [null]
            ])
            ->add([
                'options' => ['path' => 'path']
            ])
            ->add([
                'options' => ['message' => 'message']
            ])
            ->add([
                'options' => ['path' => 4545, 'message' => 'message']
            ])
            ->add([
                'options' => ['path' => 'path', 'message' => 455748]
            ])
            ->add([
                'options' => ['path' => [], 'message' => 'message']
            ])
            ->add([
                'options' => ['path' => 'path', 'message' => []]
            ])
            ->add([
                'options' => ['path' => null, 'message' => 'message']
            ])
            ->add([
                'options' => ['path' => 'path', 'message' => null]
            ])
            ->end();

        return [
            [[null]],
            [['path' => 'path']],
            [['message' => 'message']],

            [['path' => 4545, 'message' => 'message']],
            [['path' => 'path', 'message' => 455748]],
            [['path' => [], 'message' => 'message']],

            [['path' => 'path', 'message' => []]],

            [['path' => null, 'message' => 'message']],
            [['path' => 'path', 'message' => null]],

        ];
    }


}