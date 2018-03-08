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
 * Se lanza cuando se encuentran errores de sintaxis en composer.json
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class BadFormedJsonException extends \RuntimeException
{

    /**
     * Crea una excepción
     *
     * @param string     $path
     * @param \Throwable $previous
     *
     * @return \PlanB\Wand\Core\Context\Exception\BadFormedJsonException
     */
    public static function create(string $path, ?\Throwable $previous = null): self
    {
        $message = sprintf('El archivo %s no está bien formado', $path);

        return new self($message, 0, $previous);
    }
}
