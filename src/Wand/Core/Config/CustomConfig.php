<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Config;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class CustomConfig extends BaseConfig
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    protected function getConfigTree(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('custom')
            ->children();

        $this->defineTasks($root);
        $root->end();

        return $treeBuilder;
    }

    private function defineTasks(NodeBuilder $root): void
    {
        $root->arrayNode('tasks')
            ->arrayPrototype()
                ->treatFalseLike([])
                ->booleanPrototype()
                ->defaultValue(true)
                ->validate()
                    ->ifTrue(function ($value) {
                        return $value === false;
                    })
                    ->thenUnset()
                ->end()
            ->end()
            ->validate()
                ->ifEmpty()
                ->thenUnset()
            ->end()
        ->end();
    }
}
