<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Path\Exception;

/**
 * Se lanza cuando se recibe una ruta que no existe desde consola.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class InvalidProjectDirectoryException extends \RuntimeException
{
    /**
     * La ruta no existe.
     *
     * @param string     $path
     * @param \Throwable $previous
     *
     * @return \PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException
     */
    public static function notFound(string $path, ?\Throwable $previous = null): self
    {
        $message = sprintf("La ruta '%s' no existe", $path);

        return new self($message, 0, $previous);
    }

    /**
     * No se encuentra el archivo composer.json.
     *
     * @param string          $path
     * @param \Throwable|null $previous
     *
     * @return \PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException
     */
    public static function composerMissing(string $path, ?\Throwable $previous = null): self
    {
        $message = sprintf("No se encuentra el archivo composer.json en el directorio '%s', ".
        'ni en ninguno de sus padres', $path);

        return new self($message, 0, $previous);
    }
}
