<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Task;

use PlanB\Utils\Options\Options;
use PlanB\Wand\Core\Action\ActionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Gestiona los parámetros con los que se crea una tarea.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskOptions extends Options
{
    /**
     * Configura los criterios.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver): void
    {
        $this->defineActions($resolver);
        $this->defineDescription($resolver);
    }

    /**
     * Define el atributo "actions".
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function defineActions(OptionsResolver $resolver): void
    {
        $resolver->setDefined('actions');
        $resolver->setAllowedTypes('actions', ['array']);
        $resolver->setAllowedValues('actions', \Closure::fromCallable([$this, 'isValidActions']));
        $resolver->setDefault('actions', []);
    }

    /**
     * Indica si todos los elementos del array son instancias de ActionInterface.
     *
     * @param mixed[] $actions
     *
     * @return mixed
     */
    public function isValidActions(array $actions)
    {
        return array_reduce($actions, function (bool $carry, $action) {
            return $carry && $action instanceof ActionInterface;
        }, true);
    }

    /**
     * Define el attributo "description".
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function defineDescription(OptionsResolver $resolver): void
    {
        $resolver->setDefined('description');
        $resolver->setAllowedTypes('description', 'string');
        $resolver->setDefault('description', '');
    }
}
