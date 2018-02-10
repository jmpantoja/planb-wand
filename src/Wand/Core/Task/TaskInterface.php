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
 * Modela una tarea
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
interface TaskInterface
{
    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $params
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    /**
     * @inheritdoc
     *
     * @param array $params
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public static function create(array $params): TaskInterface;
}
