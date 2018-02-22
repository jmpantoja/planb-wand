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

use PlanB\Wand\Core\Action\Exception\InvalidServiceTypeException;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Clase Base para acciones
 *
 * @package PlanB\Wand\Core\Action
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Action implements ActionInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    private $container;

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
     * Devuelve el PathManager
     *
     * @return \PlanB\Wand\Core\Path\PathManager
     */
    public function getPathManager(): PathManager
    {
        $name = 'wand.path.manager';
        $manager = $this->container->get($name);

        if (!($manager instanceof PathManager)) {
            throw InvalidServiceTypeException::create($name, PathManager::class, get_class($manager));
        }

        return $manager;
    }
}
