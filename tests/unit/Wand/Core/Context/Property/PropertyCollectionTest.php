<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Property;


/**
 * Options Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property\PropertyCollection
 */
class PropertyCollectionTest extends Unit
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
     * @covers ::getAll
     *
     */
    public function testGetAll()
    {
        $properties = PropertyCollection::getAll();

        $this->assertContainsOnlyInstancesOf(Property::class, $properties);
        $this->tester->assertEquals([
            'package_name',
            'package_description',
            'package_type',
            'license',
            'author_name',
            'author_email',
            'author_homepage',
            'github_username',
        ], array_keys($properties));

    }

}