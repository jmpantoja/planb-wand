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
 * Propiedad package name.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PackageNameProperty extends Property implements ValidableProperty
{
    /**
     * Define los parámetros path y message.
     *
     * @param string[] $options
     */
    public function init(array &$options): void
    {
        $options['path'] = '[name]';
        $options['message'] = 'Package Name';
    }

    /**
     * {@inheritdoc}
     */
    public function validate($answer): bool
    {
        return (bool) preg_match('/.*\/.*/', $answer);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(string $answer): string
    {
        return sprintf('El formato de nombre "%s" no es correcto, se esperaba "<vendor>/<package>"', $answer);
    }
}
