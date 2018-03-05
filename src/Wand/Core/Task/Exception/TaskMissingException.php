<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Task\Exception;

/**
 * Se lanza cuando se pide una tarea que no existe.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskMissingException extends \RuntimeException
{
    /**
     * La tarea solicitada no existe.
     *
     * @param string          $task
     * @param string[]        $availables
     * @param null|\Throwable $previous
     *
     * @return \PlanB\Wand\Core\Task\Exception\TaskMissingException
     */
    public static function create(string $task, array $availables, ?\Throwable $previous = null): self
    {
        $textAvailables = implode('|', $availables);
        $message = sprintf("La tarea '%s' no está definida (disponibles %s)", $task, $textAvailables);

        return new self($message, 0, $previous);
    }
}
