<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Context;

use PlanB\Utils\Options\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Gestiona el juego de opciones de Property.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PropertyOptions extends Options
{
    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver): void
    {
        $this->definePath($resolver);
        $this->defineMessage($resolver);
    }

    /**
     * Define el atributo path
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function definePath(OptionsResolver $resolver): void
    {
        $resolver->setRequired('path');
        $resolver->setAllowedTypes('path', ['string']);
    }

    /**
     * Define el atributo message
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineMessage(OptionsResolver $resolver): void
    {
        $resolver->setRequired('message');

        $resolver->setAllowedTypes('message', ['string']);
        $resolver->setNormalizer('message', \Closure::fromCallable([$this, 'normalizeMessage']));
    }

    /**
     * Normaliza el texto del mensaje
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     * @param string                                             $message
     *
     * @@SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return string
     */
    protected function normalizeMessage(OptionsResolver $resolver, string $message): string
    {
        return sprintf('%s: ', trim($message));
    }
}
