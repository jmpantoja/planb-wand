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
 * Gestiona el juego de opciones de Property
 *
 * @package PlanB\Wand\Core\Context
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PropertyOptions extends Options
{

    /**
     * @inheritdoc
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver): void
    {
        $this->definePath($resolver);
        $this->defineMessage($resolver);
    }

    private function definePath(OptionsResolver $resolver): void
    {
        $resolver->setRequired('path');
        $resolver->setAllowedTypes('path', ['string']);
    }

    private function defineMessage(OptionsResolver $resolver): void
    {
        $resolver->setRequired('message');

        $resolver->setAllowedTypes('message', ['string']);
        $resolver->setNormalizer('message', function (OptionsResolver $resolver, string $message) {
            return sprintf('%s: ', trim($message));
        });
    }
}
