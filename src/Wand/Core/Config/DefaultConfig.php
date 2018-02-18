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

final class DefaultConfig extends BaseConfig
{

    /**
     * @inheritdoc
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    protected function getConfigTree(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('default')
            ->children();

        $this->defineTasks($root);
        $root->end();

        return $treeBuilder;
    }

    private function defineTasks(NodeBuilder $root): void
    {
        $root->arrayNode('tasks')
            ->arrayPrototype()
            ->append($this->getClassNameNode(TaskInterface::class, Task::class))
            ->append($this->getDescriptionNode())
            ->append($this->getActionsNode())
            ->end();
    }

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
            })->thenInvalid("debería ser del tipo " . $interface)
            ->end()
            ->end();

        return $node;
    }

    private function getDescriptionNode(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('description');
        $node->cannotBeEmpty()
            ->end();

        return $node;
    }

    private function getActionsNode(): ArrayNodeDefinition
    {
        $node = new ArrayNodeDefinition('actions');

        $node->arrayPrototype()
            ->children()
            ->append($this->getActionGroupNode())
            ->append($this->getClassNameNode(ActionInterface::class))
            ->append($this->getParamsNode())
            ->end();

        return $node;
    }


    private function getActionGroupNode(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('group');
        $node->cannotBeEmpty()
            ->end();

        return $node;
    }

    private function getParamsNode(): ArrayNodeDefinition
    {
        $node = new ArrayNodeDefinition('params');

        $node->scalarPrototype()
            ->end();

        return $node;
    }

    /**
     *
     * @param mixed[] $custom
     * @return mixed[]
     */
    public function processWithFilter(array $custom): array
    {
        $config = $this->process();

        $filter = ConfigFilter::create($config, $custom);
        $config['tasks'] = $filter->process();

        return $config;
    }
}
