<?php declare(strict_types=1);

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
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Verifica las opciones de un objeto Command.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class CommandOptions extends Options
{

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver): void
    {
        $this->definePattern($resolver);
        $this->defineGroup($resolver);
        $this->defineTitle($resolver);
        $this->defineOnlyModified($resolver);

        $profile = $this->getProfile();
        if ('symfony' === $profile) {
            $this->defineCommand($resolver);
        } else {
            $this->defineCwd($resolver);
        }
    }

    /**
     * Define el atributo 'cmd'.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function definePattern(OptionsResolver $resolver): void
    {
        $resolver->setRequired('pattern');
        $resolver->addAllowedTypes('pattern', ['string', 'null']);
    }

    /**
     * Define el atributo 'cwd'.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineCwd(OptionsResolver $resolver): void
    {
        $resolver->setRequired('cwd');
        $resolver->addAllowedTypes('cwd', ['string', 'null']);
        $resolver->addAllowedValues('cwd', ['vendor/bin', null]);
        $resolver->setDefault('cwd', null);
    }

    /**
     * Define el atributo 'command'.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineCommand(OptionsResolver $resolver): void
    {
        $resolver->setRequired('command');
        $resolver->addAllowedTypes('command', ['string']);
        $resolver->addAllowedValues('command', \Closure::fromCallable([$this, 'validateCommand']));
    }

    /**
     * Indica si un comando es correcto
     *
     * @param string $value
     *
     * @return bool
     */
    protected function validateCommand(string $value): bool
    {
        return is_subclass_of($value, ConsoleCommand::class);
    }

    /**
     * Define el atributo 'group'.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineGroup(OptionsResolver $resolver): void
    {
        $resolver->setRequired('group');
        $resolver->addAllowedTypes('group', 'string');
    }

    /**
     * Define el atributo 'group'.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineTitle(OptionsResolver $resolver): void
    {
        $resolver->setDefined('title');
        $resolver->addAllowedTypes('title', ['string', 'null']);
        $resolver->setDefault('title', null);
    }


    /**
     * Define el atributo 'group'.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function defineOnlyModified(OptionsResolver $resolver): void
    {
        $resolver->setDefined('only_modified');
        $resolver->addAllowedTypes('only_modified', ['bool']);
        $resolver->setDefault('only_modified', false);
    }
}
