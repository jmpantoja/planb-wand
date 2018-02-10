<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\WandBundle\Command;

use PlanB\Wand\Core\Task\TaskManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Comando con funcionalidades comunes
 *
 * @package PlanB\WandBundle\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class BaseCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container ;
     */
    private $container;

    /**
     * WandCommand constructor.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|null $container
     */
    public function __construct(?ContainerInterface $container = null)
    {
        $this->setContainer($container);
        parent::__construct('wand');
    }

    /**
     * @inheritdoc
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|null $container
     */
    public function setContainer(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Devuelve el contenedor
     *
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    /**
     * Devuelve el gestor de tareas
     *
     * @return \PlanB\Wand\Core\Task\TaskManager
     */
    public function getTaskManager(): TaskManager
    {
        return $this->container->get('wand.task.manager');
    }
}
