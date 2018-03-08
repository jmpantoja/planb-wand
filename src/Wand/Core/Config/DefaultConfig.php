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

use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Valida la configuración por defecto
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class DefaultConfig extends BaseConfig
{
    /**
     * {@inheritdoc}
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    protected function getConfigTree(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('default')
            ->children();

        $this->defineActions($root);
        $this->defineTasks($root);
        $root->end();

        return $treeBuilder;
    }

    /**
     * Define el nodo acciones
     *
     * @param \Symfony\Component\Config\Definition\Builder\NodeBuilder $root
     */
    private function defineActions(NodeBuilder $root): void
    {
        $root->arrayNode('actions')
            ->arrayPrototype()
            ->children()
            ->append($this->getActionGroupNode())
            ->append($this->getClassNameNode(ActionInterface::class))
            ->append($this->getParamsNode())
            ->end();
    }

    /**
     * Define el nodo action/group
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    private function getActionGroupNode(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('group');
        $node->cannotBeEmpty()
            ->end();

        return $node;
    }

    /**
     * Define el nodo classname
     *
     * @param string      $interface
     * @param null|string $default
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    private function getClassNameNode(string $interface, ?string $default = null): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('classname');
        if (!empty($default)) {
            $node->defaultValue($default);
        }

        $node->cannotBeEmpty()
            ->validate()
            ->ifTrue(function ($className) use ($interface) {
                return !is_subclass_of($className, $interface);
            })->thenInvalid('debería ser del tipo '.$interface)
            ->end()
            ->end();

        return $node;
    }

    /**
     * Define el nodo params
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
     */
    private function getParamsNode(): ArrayNodeDefinition
    {
        $node = new ArrayNodeDefinition('params');

        $node->scalarPrototype()
            ->end();

        return $node;
    }

    /**
     * Define el nodo tasks
     *
     * @param \Symfony\Component\Config\Definition\Builder\NodeBuilder $root
     */
    private function defineTasks(NodeBuilder $root): void
    {
        $root->arrayNode('tasks')
            ->arrayPrototype()
            ->append($this->getClassNameNode(TaskInterface::class, Task::class))
            ->append($this->getDescriptionNode())
            ->append($this->getActionsNode())
            ->end();
    }


    /**
     * Define el nodo task/description
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    private function getDescriptionNode(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('description');
        $node->cannotBeEmpty()
            ->end();

        return $node;
    }

    /**
     * Define le nodo task/actions
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
     */
    private function getActionsNode(): ArrayNodeDefinition
    {
        $node = new ArrayNodeDefinition('actions');

        $node->arrayPrototype()
            ->children()
            ->end();

        return $node;
    }
}
