<?php

namespace PlanB\Wand\Core\Context;

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Utils\Tdd\Mock\Double;


/**
 * Options Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\PropertyOptions
 */
class PropertyOptionsTest extends Unit
{


    /**
     * @test
     *
     *
     * @covers ::configure
     * @covers ::definePath
     * @covers ::defineMessage
     * @covers ::resolve
     *
     */
    public function testCreate()
    {
        /** @var PropertyOptions $target */
        $target = PropertyOptions::create();
        $this->assertInstanceOf(PropertyOptions::class, $target);

        $options = [
            'path' => '[path]',
            'message' => 'message'
        ];

        $params = $target->resolve($options);

        $this->assertEquals('[path]', $params['path']);
        $this->assertEquals('message: ', $params['message']);

    }


    /**
     * @test
     *
     * @dataProvider providerCreate
     *
     * @covers ::configure
     * @covers ::definePath
     * @covers ::defineMessage
     * @covers ::resolve
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidArgumentException
     */
    public function testCreateException($options)
    {
        /** @var PropertyOptions $target */
        $target = PropertyOptions::create();
        $this->assertInstanceOf(PropertyOptions::class, $target);

        $target->resolve($options);

    }

    public function providerCreate()
    {
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