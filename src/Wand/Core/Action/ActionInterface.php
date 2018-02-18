<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Action;

interface ActionInterface
{
    /**
     * Devuelve el nombre del evento asociado a esta acción
     *
     * @return string
     */
    public function getEventName(): string;
}
