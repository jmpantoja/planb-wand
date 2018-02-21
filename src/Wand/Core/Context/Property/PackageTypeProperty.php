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

/**
 * Propiedad package type
 *
 * @package PlanB\Wand\Core\Context\Property
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PackageTypeProperty extends Property
{

    /**
     * Define los parámetros path y message
     *
     * @param string[] $options
     */
    public function init(array &$options): void
    {
        $options['path'] = '[type]';
        $options['message'] = 'Package Type';
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return [
            'library',
            'project',
            'metapackage',
            'composer-plugin',
        ];
    }
}
