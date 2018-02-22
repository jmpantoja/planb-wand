<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Action\Exception;

/**
 * Se lanza cuando pedimos un servicio al contenedor
 * y no devuelve el tipo esperado
 *
 * @package PlanB\Wand\Core\Action\Exception
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class InvalidServiceTypeException extends \RuntimeException
{

    /**
     * Crea una instancia
     *
     * @param string $name
     * @param string $expected
     * @param string $returned
     * @param \Throwable|null $previous
     * @return \PlanB\Wand\Core\Action\Exception\InvalidServiceTypeException
     */
    public static function create(string $name, string $expected, string $returned, ?\Throwable $previous = null): self
    {

        $message = sprintf(
            "Se esperaba que el servicio '%s' fuera del tipo '%s', pero ha devuelto un '%s'",
            $name,
            $expected,
            $returned
        );

        return new self($message, 0, $previous);
    }
}
