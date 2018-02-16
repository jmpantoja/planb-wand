<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Task;

/**
 * Tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class Task implements TaskInterface
{

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var \PlanB\Wand\Core\Action\ActionInterface[] $actions ;
     */
    private $actions;

    /**
     * Task constructor.
     *
     * @param mixed[] $options
     */
    final public function __construct(array $options)
    {
        $this->description = $options['description'];
        $this->actions = $options['actions'];
    }

    /**
     * @inheritdoc
     *
     * @param array $params
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    final public static function create(array $params): TaskInterface
    {
        $options = TaskOptions::create()
            ->resolve($params);

        return new self($options);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }
}
