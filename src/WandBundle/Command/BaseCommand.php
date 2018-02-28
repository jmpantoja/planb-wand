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

use PlanB\Wand\Core\Context\ContextManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;

use PlanB\Wand\Core\Task\TaskManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

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

    /**
     * Devuelve el gestor de la aplicacion
     *
     * @return \PlanB\Wand\Core\Logger\LogManager
     */
    public function getTaskRunner(): LogManager
    {
        return $this->container->get('wand.task.runner');
    }

    /**
     * Devuelve el gestor de rutas
     *
     * @return \PlanB\Wand\Core\Path\PathManager
     */
    public function getPathManager(): PathManager
    {
        return $this->container->get('wand.path.manager');
    }

    /**
     * Devuelve el gestor de contexto
     *
     * @return \PlanB\Wand\Core\Context\ContextManager
     */
    public function getContextManager(): ContextManager
    {
        return $this->container->get('wand.context.manager');
    }


    /**
     * Devuelve el dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher(): EventDispatcher
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * Devuelve el gestor de logs
     *
     * @return \PlanB\Wand\Core\Logger\LogManager
     */
    public function getLogger(): LogManager
    {
        return $this->container->get('wand.log.manager');
    }
}
