<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Context\Exception;

/**
 * Se lanza cuando se pide una ruta que no existe.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class UnknowPathException extends \RuntimeException
{
    /**
     * Crea una instancia de la excepción.
     *
     * @param string          $path
     * @param string[]        $availables
     * @param \Throwable|null $previous
     * @return \PlanB\Wand\Core\Context\Exception\UnknowPathException
     */
    public static function create(string $path, array $availables, ?\Throwable $previous = null): UnknowPathException
    {
        $message = sprintf("La ruta '%s' no existe. (disponibles: %s)", $path, implode('|', $availables));

        return new self($message, 0, $previous);
    }
}
