<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Context\Property;

use PlanB\Wand\Core\Context\Property;
use PlanB\Wand\Core\Context\ValidableProperty;

/**
 * Propiedad Author Homepage.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class AuthorHomepageProperty extends Property implements ValidableProperty
{
    /**
     * Define los parámetros path y message.
     *
     * @param string[] $options
     */
    public function init(array &$options): void
    {
        $options['path'] = '[authors][0][homepage]';
        $options['message'] = 'Github Username';
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($answer)
    {
        return sprintf('https://github.com/%s/', $answer);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($answer): ?string
    {
        $matches = [];
        if (preg_match('#https://github.com/(.*?)/#', $answer, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Realiza las comprobaciones especificas de esta propiedad.
     *
     * @param mixed $answer
     *
     * @return bool
     */
    public function validate($answer): bool
    {
        return (bool) $this->denormalize($answer);
    }

    /**
     * Devuelve el mensaje de error personalizado.
     *
     * @param string $answer
     *
     * @return string
     */
    public function getErrorMessage(string $answer): string
    {
        $format = 'El formato de author homepage "%s" no es correcto, se esperaba "https://github.com/<username>/"';

        return sprintf($format, $answer);
    }
}
