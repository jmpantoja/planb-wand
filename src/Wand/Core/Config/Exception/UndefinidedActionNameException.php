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
class UndefinidedActionNameException extends \RuntimeException
{
    /**
     * Crea una nueva instancia
     *
     * @param string $task
     * @param string[] $names
     * @param string[] $availables
     * @param \Throwable|null $previous
     * s
     * @return \PlanB\Wand\Core\Config\Exception\UndefinidedActionNameException
     */
    public static function create(string $task, array $names, array $availables, ?\Throwable $previous = null): self
    {

        $names = array_map(function ($name) use ($task) {
            return sprintf('%s/%s', $task, $name);
        }, $names);

        $availablesText = implode('|', $availables);
        if (count($names) > 1) {
            $namesText = implode('|', $names);
            $message = sprintf("La acciones '%s' no existen, (disponibles: %s)", $namesText, $availablesText);
        } else {
            $name = array_shift($names);
            $message = sprintf("La acción '%s' no existe (disponibles: %s)", $name, $availablesText);
        }

        return new self($message, 0, $previous);
    }
}
