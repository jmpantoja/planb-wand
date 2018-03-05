<?php declare(strict_types = 1);

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
 * Clase Base para acciones.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Action implements ActionInterface
{

    /**
     * @var int
     */
    protected $level = 0;

    /**
     * @var \PlanB\Wand\Core\Context\Context
     */
    protected $context;

    /**
     * Devuelve el nivel de esta acción.
     *
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $level
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function setLevel(int $level): ActionInterface
    {
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param \PlanB\Wand\Core\Context\Context $context
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function setContext(Context $context): ActionInterface
    {
        $this->context = $context;

        return $this;
    }
}
