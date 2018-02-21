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
 * Propiedad GithubUsername
 *
 * @package PlanB\Wand\Core\Context\Property
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class GithubUsernameProperty extends AuthorHomepageProperty
{
    /**
     * @inheritDoc
     */
    public function resolve($answer): ?string
    {
        return $this->denormalize($answer);
    }
}
