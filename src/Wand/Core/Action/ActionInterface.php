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

use PlanB\Wand\Core\Context\Context;

/**
 * Modela una acción.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
interface ActionInterface
{
    /**
     * Asigna el nivel en la jerarquia de tareas/acciones.
     *
     * @param int $level
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function setLevel(int $level): ActionInterface;

    /**
     * Asigna el contexto.
     *
     * @param \PlanB\Wand\Core\Context\Context $context
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function setContext(Context $context): ActionInterface;
}
