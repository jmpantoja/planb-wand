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

class LicenseProperty extends Property
{

    /**
     * Define los parámetros path y message
     *
     * @param string[] $options
     */
    public function init(array &$options): void
    {
        $options['path'] = '[license]';
        $options['message'] = 'License';
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return [
            'MIT',
            'Apache-2.0',
            'Unlicense',
        ];
    }
}
