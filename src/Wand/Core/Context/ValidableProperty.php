<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Context;

/**
 * Representa a las propiedades que tienen una validación específica
 *
 * @package PlanB\Wand\Core\Context
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
interface ValidableProperty
{
    /**
     * Realiza las comprobaciones especificas de esta propiedad
     *
     * @param mixed $answer
     * @return bool
     */
    public function validate($answer): bool;

    /**
     * Devuelve el mensaje de error personalizado
     *
     * @return string
     */
    public function getErrorMessage(string $answer): string;
}
