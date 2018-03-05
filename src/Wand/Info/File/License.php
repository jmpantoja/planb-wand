<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Info\File;

use PlanB\Wand\Core\File\File;

/**
 * Representa al archivo LICENSE.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class License extends File
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public static function getProfile(): string
    {
        return 'without-template';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): string
    {
        $license = $this->context->getParam('license');

        return sprintf('@wand.projectInfo/license/%s.twig', strtolower($license));
    }
}
