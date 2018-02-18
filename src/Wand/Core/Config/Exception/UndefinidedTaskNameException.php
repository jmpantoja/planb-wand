<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Config\Exception;

/**
 * Se lanza cuando en la configuración custom se trata de definir una tarea que no existe en default
 *
 * @package PlanB\Wand\Core\App\Exception
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class UndefinidedTaskNameException extends \RuntimeException
{
    /**
     * Crea una nueva instancia
     *
     * @param string[] $names
     * @param string[] $availables
     * @param \Throwable|null $previous
     * s
     * @return \PlanB\Wand\Core\Config\Exception\UndefinidedTaskNameException
     */
    public static function create(array $names, array $availables, ?\Throwable $previous = null): self
    {

        $availablesText = implode('|', $availables);
        if (count($names) > 1) {
            $namesText = implode('|', $names);
            $message = sprintf("La tareas '%s' no existen, (disponibles: %s)", $namesText, $availablesText);
        } else {
            $name = array_shift($names);
            $message = sprintf("La tarea '%s' no existe (disponibles: %s)", $name, $availablesText);
        }

        return new self($message, 0, $previous);
    }
}
