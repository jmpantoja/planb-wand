<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Command;

use PlanB\Utils\Options\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Verifica las opciones de un objeto Command
 *
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class CommandOptions extends Options
{

    /**
     * @inheritdoc
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver): void
    {
        $this->definePattern($resolver);
        $this->defineCwd($resolver);
        $this->defineGroup($resolver);
    }

    /**
     * Define el atributo 'cmd'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function definePattern(OptionsResolver $resolver): void
    {
        $resolver->setRequired('pattern');
        $resolver->addAllowedTypes('pattern', ['string', 'null']);
    }


    /**
     * Define el atributo 'cwd'
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineCwd(OptionsResolver $resolver): void
    {
        $resolver->setRequired('cwd');
        $resolver->addAllowedTypes('cwd', ['string', 'null']);
        $resolver->addAllowedValues('cwd', ['vendor/bin', 'wand-vendor/bin']);
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
}
