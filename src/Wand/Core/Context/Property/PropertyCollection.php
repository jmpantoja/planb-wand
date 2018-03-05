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

/**
 * Gestiona el listado de propiedades
 *
 * @package PlanB\Wand\Core\Context\Property
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PropertyCollection
{
    /**
     * Devuelve el listado de propiedades
     *
     * @return \PlanB\Wand\Core\Context\Property[]
     */
    public static function getAll(): array
    {
        $properties = [];
        $properties['package_name'] = PackageNameProperty::create();
        $properties['package_description'] = PackageDescriptionProperty::create();
        $properties['package_type'] = PackageTypeProperty::create();
        $properties['license'] = LicenseProperty::create();
        $properties['author_name'] = AuthorNameProperty::create();
        $properties['author_email'] = AuthorEmailProperty::create();
        $properties['author_homepage'] = AuthorHomepageProperty::create();
        $properties['github_username'] = GithubUsernameProperty::create();

        return $properties;
    }
}
