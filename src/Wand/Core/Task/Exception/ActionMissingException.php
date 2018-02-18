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
 * Se lanza cuando se pide una tarea que no existe
 *
 * @package PlanB\Wand\Core\Task\Exception
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ActionMissingException extends \RuntimeException
{
    /**
     * La acción solicitada no existe
     *
     * @param string $action
     * @param string[] $availables
     * @param null|\Throwable $previous
     *
     * @return \PlanB\Wand\Core\Task\Exception\ActionMissingException
     */
    public static function create(string $action, array $availables, ?\Throwable $previous = null): self
    {
        $textAvailables = implode('|', $availables);
        $message = sprintf("La acción '%s' no está definida (disponibles %s)", $action, $textAvailables);

        return new self($message, 0, $previous);
    }
}
