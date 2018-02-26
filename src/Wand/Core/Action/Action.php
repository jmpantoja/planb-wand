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
 * Clase Base para acciones
 *
 * @package PlanB\Wand\Core\Action
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Action implements ActionInterface
{
    /**
     * @var \PlanB\Wand\Core\Context\Context $context
     */
    protected $context;

    /**
     * Asigna el contexto
     *
     * @param \PlanB\Wand\Core\Context\Context $context
     * @return \PlanB\Wand\Core\Action\Action
     */
    public function setContext(Context $context): self
    {
        $this->context = $context;
        return $this;
    }
}
