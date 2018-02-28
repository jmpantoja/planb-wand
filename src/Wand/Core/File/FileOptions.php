<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use PlanB\Utils\Options\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Verifica las opciones de un objeto File
 *
 * @package PlanB\Wand\Core\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class FileOptions extends Options
{

    /**
     * @inheritdoc
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver): void
    {
        $this->defineAction($resolver);
        $this->defineChmod($resolver);
        $this->defineGroup($resolver);
        $this->defineTarget($resolver);

        if ($this->getProfile() === 'without-template') {
            return;
        }

        $this->defineTemplate($resolver);
    }

    /**
     * Define el atributo 'action'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineAction(OptionsResolver $resolver): void
    {
        $resolver->setDefined('action');
        $resolver->addAllowedTypes('action', ['string', 'null']);
        $resolver->addAllowedValues('action', [File::ACTION_CREATE, File::ACTION_REMOVE, File::ACTION_OVERWRITE]);

        $resolver->setDefault('action', File::ACTION_CREATE);
    }


    /**
     * Define el atributo 'chmod'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineChmod(OptionsResolver $resolver): void
    {
        $resolver->setDefined('chmod');
        $resolver->addAllowedTypes('chmod', ['int', 'null']);
        $resolver->setDefault('chmod', 0644);
    }


    /**
     * Define el atributo 'group'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineGroup(OptionsResolver $resolver): void
    {
        $resolver->setRequired('group');
        $resolver->addAllowedTypes('group', 'string');
    }


    /**
     * Define el atributo 'target'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineTarget(OptionsResolver $resolver): void
    {
        $resolver->setRequired('target');
        $resolver->addAllowedTypes('target', 'string');
    }

    /**
     * Define el atributo 'template'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineTemplate(OptionsResolver $resolver): void
    {
        $resolver->setRequired('template');
        $resolver->addAllowedTypes('template', 'string');
    }
}
