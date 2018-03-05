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
 * Se lanza cuando una acción existe, pero no es del tipo esperado.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class InvalidTypeActionException extends \RuntimeException
{
    /**
     * Crea una nueva instancia.
     *
     * @param string          $name
     * @param string          $expected
     * @param \Throwable|null $previous
     *
     * @return \PlanB\Wand\Core\Task\Exception\InvalidTypeActionException
     */
    public static function create(string $name, string $expected, ?\Throwable $previous = null): self
    {
        $message = sprintf("La acción '%s' no es del tipo correcto (se esperaba %s)", $name, $expected);

        return new self($message, 0, $previous);
    }
}
